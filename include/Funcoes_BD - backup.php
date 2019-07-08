<?php

class Funcoes_BD{
	
	private $conn;
	
	function __construct(){
		require_once 'Conexao_BD.php';
		require_once 'Email.php';
		
		$bd = new Conexao_BD();
		$this->conn = $bd->conexao();	
	}
	
	/* 	Armazena Usuário 
		Retorna detalhes do usuário
	*/
	
	public function armazenaUsuario($nome, $email, $telefone, $senha){
		
		$senha_criptografada = $this->criptoSenha($senha);
		$token = md5(time());
		$link = "http://danielfalsetti-001-site7.ftempurl.com:80/confirmacao.php?email=$email&token=$token";
		
		if(smtpmailer($email, 'noreply@manutencaoveicular.com.br', 'Projeto Carro', 'Confirmacao Email', 'Clique no link para confirmar sua conta: ' .$link)){
			
			$stmt = $this->conn->prepare("INSERT INTO tb_usuario(S_NOME, S_EMAIL, N_TELEFONE, S_SENHA, D_DATA_CRIACAO, S_TOKEN) VALUES( ?, ?, ?, ?, NOW(), ?)");
			$stmt->bind_param("sssss", $nome, $email, $telefone, $senha_criptografada, $token);
			$stmt->execute();
			$stmt->close();
			return true;			
			
		} else {
			
			return false;
			
		}
		
	}
	
	public function armazenaVeiculo($marca, $modelo, $ano, $placa, $km, $usuario, $dispositivo) {
		
			$stmt = $this->conn->prepare("INSERT INTO tb_veiculo(S_MARCA, S_MODELO, D_ANO, S_PLACA, N_KM, I_USER, N_DISPOSITIVO) VALUES( ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssss", $marca, $modelo, $ano, $placa, $km, $usuario, $dispositivo);
			
			if($stmt->execute()) {
				$stmt->close();
				return true;				
			} else {
				return false;
			}		
	}
	
	
	
	
	/* Verifica e retorna Usuário atraves do email e senha*/
	public function obtemUsuarioPorEmailESenha($email, $senha){
		
		$stmt = $this->conn->prepare("SELECT * FROM tb_usuario WHERE S_EMAIL = ?");
		$stmt->bind_param("s",$email);
		
		if($stmt->execute()){
			
			$usuario = $stmt->get_result()->fetch_assoc();
			$stmt->close();
			
			if($this->criptoSenha($senha) == $usuario['S_SENHA']){
				
				return $usuario;
				
			} else {
			
				return NULL;
			
			}
				
		} else {
			
			return NULL;
		}
		
	}
	
	public function verificaUsuarioExistente($email){
		
		$stmt = $this->conn->prepare("SELECT S_EMAIL from tb_usuario WHERE S_EMAIL = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
		
		if ($stmt->num_rows > 0) {
            // usuário existe
            $stmt->close();
            return true;
        } else {
            // usuário não existe
            $stmt->close();
            return false;
        }
	}
	
	public function verificaUsuarioExistentePeloID($id){
		
		$stmt = $this->conn->prepare("SELECT S_EMAIL from tb_usuario WHERE ID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
		
		if ($stmt->num_rows > 0) {
            // usuário existe
            $stmt->close();
            return true;
        } else {
            // usuário não existe
            $stmt->close();
            return false;
        }
	}
	
	public function verificaDispositivoEmUso($dispositivo){
		
		$stmt = $this->conn->prepare("SELECT N_DISPOSITIVO from tb_veiculo WHERE N_DISPOSITIVO = ?");
        $stmt->bind_param("s", $dispositivo);
        $stmt->execute();
        $stmt->store_result();
		
		if ($stmt->num_rows > 0) {
            // usuário existe
            $stmt->close();
            return true;
        } else {
            // usuário não existe
            $stmt->close();
            return false;
        }
	}
		
	
	public function verificaVeiculoExistente($placa) {
		
		$stmt = $this->conn->prepare("SELECT S_PLACA from tb_veiculo WHERE S_PLACA = ?");
        $stmt->bind_param("s", $placa);
        $stmt->execute();
        $stmt->store_result();
		
		if ($stmt->num_rows > 0) {
            // veiculo existe
            $stmt->close();
            return true;
        } else {
            // veiculo não existe
            $stmt->close();
            return false;
        }
	}
	
	
	
	public function enviaEmailConfirmacao($email, $senha){
		
		$usuario = $this->obtemUsuarioPorEmailESenha($email, $senha);
		
		if($usuario) {
			
			$token = $usuario['S_TOKEN'];
			$link = "http://danielfalsetti-001-site7.ftempurl.com:80/confirmacao.php?email=$email&token=$token";
			if(smtpmailer($email, 'noreply@manutencaoveicular.com.br', 'Projeto Carro', 'Confirmacao Email', 'Clique no link para confirmar seu email: ' .$link)){
				
				return true;
				
			} else {
				
				return false;
				
			}
		} else {
			
			return false;
			
		}
	}
	
	public function verificaUsuarioPorEmailEToken($email, $token){
		
		$stmt = $this->conn->prepare("SELECT * FROM tb_usuario WHERE S_EMAIL = ? AND S_TOKEN = ?");
		$stmt->bind_param("ss", $email, $token);
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows>0){
			
			$stmt->close();
			return true;
			
		} else {
			
			$stmt->close();
			return false;
			
		}
		
	}
	
	public function verificaUsuarioConfirmado($email, $token){
		
		$stmt = $this->conn->prepare("SELECT * FROM tb_usuario WHERE S_EMAIL = ? AND S_TOKEN = ? AND B_CONFIRMACAO = 1");
		$stmt->bind_param("ss", $email, $token);
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows>0){
			
			$stmt->close();
			return true;
			
		} else {
			
			$stmt->close();
			return false;
			
		}
		
	}
	
	public function confirmaUsuario($email, $token) {
	
		$stmt = $this->conn->prepare("UPDATE tb_usuario SET B_CONFIRMACAO = 1 WHERE S_EMAIL = ? AND S_TOKEN = ?");
		$stmt->bind_param("ss",$email, $token);
		
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        else {
			$stmt->close();
            return false;
        } 
	
	}
	
	public function atualizaUsuario($nome, $email, $telefone){
		
		$stmt = $this->conn->prepare("SELECT S_NOME, N_TELEFONE from tb_usuario WHERE S_EMAIL = ?");
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_assoc();
		$stmt->close();
		
		$nome_antigo = $result["S_NOME"];
		$telefone_antigo = $result["N_TELEFONE"];
		
		if($nome == $nome_antigo && $telefone == $telefone_antigo) {
			
			return false;
		
		} else {
			
			$stmt = $this->conn->prepare("UPDATE tb_usuario SET S_NOME = ?, N_TELEFONE = ? WHERE S_EMAIL = ?");
			$stmt->bind_param("sss", $nome, $telefone, $email);
			$result = $stmt->execute();
			$stmt->close();
			
			if($result) {
				
				$stmt = $this->conn->prepare("SELECT * FROM tb_usuario WHERE S_EMAIL = ?");
				$stmt->bind_param("s", $email);
				$stmt->execute();
				$usuario = $stmt->get_result()->fetch_assoc();
				$stmt->close();
				
				return $usuario;
				
			} else {
				
				return false;
				
			}
			
		}		

	}
	
	public function obtemVeiculosPorUsuario($idusuario) {
		
		$stmt = $this->conn->prepare("SELECT * FROM tb_veiculo WHERE I_USER = ?");
		$stmt->bind_param("s", $idusuario);
		$stmt->execute();
		$result = $stmt->get_result();
				
		if(!empty($result)) {
			
			if($result->num_rows > 0) {
				
				$veiculos = array();				
				while($linha = $result->fetch_assoc()) {
					
					$veiculo = array();
					$veiculo["marca"] = $linha["S_MARCA"];
					$veiculo["modelo"] = $linha["S_MODELO"];
					$veiculo["ano"] = $linha["D_ANO"];
					$veiculo["placa"] = $linha["S_PLACA"];
					$veiculo["km"] = $linha["N_KM"];
					$veiculo["id_dispositivo"] = $linha["N_DISPOSITIVO"];
					array_push($veiculos,$veiculo);
				}
				$stmt->close();				
				return $veiculos;
										
			} else {
				$stmt->close();
				return false;
			}
			
		} else {
			$stmt->close();
			return false;
		}		
	}
	
	public function atualizaInfoVeiculo($marca, $modelo, $ano, $dispositivo, $placa) {
		
		$stmt = $this->conn->prepare("SELECT S_MARCA, S_MODELO, D_ANO, N_DISPOSITIVO from tb_veiculo WHERE S_PLACA = ?");
		$stmt->bind_param("s",$placa);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_assoc();
		$stmt->close();
		
		$marca_antigo = $result["S_MARCA"];
		$modelo_antigo = $result["S_MODELO"];
		$ano_antigo = $result["D_ANO"];
		$dispositivo_antigo = $result["N_DISPOSITIVO"];
		
		if($marca == $marca_antigo && $modelo == $modelo_antigo && $ano == $ano_antigo && $dispositivo == $dispositivo_antigo ) {
			
			return false;
		
		} else {
			
			$stmt = $this->conn->prepare("UPDATE tb_veiculo SET S_MARCA = ?, S_MODELO = ?, D_ANO = ?, N_DISPOSITIVO = ? WHERE S_PLACA = ?");
			$stmt->bind_param("sssss", $marca, $modelo, $ano, $dispositivo, $placa);
			
			if($stmt->execute()) {
				
				$stmt->close();			
				return true;
			
			} else {
				
				$stmt->close();			
				return false;
				
			}
						
		}
		
	}
	
	public function somaKmDoVeiculo($km, $dispositivo) {
		
		$stmt = $this->conn->prepare("UPDATE tb_veiculo SET N_KM = N_KM + ? WHERE N_DISPOSITIVO = ?");
		$stmt->bind_param("ds", $km, $dispositivo);
		
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        else {
			$stmt->close();
            return false;
        } 
				
	}
	
	public function mostraInfoVeiculo($placa, $usuario) {

		$stmt = $this->conn->prepare("SELECT * FROM tb_veiculo WHERE S_PLACA = ? AND I_USER = ?");
		$stmt->bind_param("ss", $placa, $usuario);
			
		if($stmt->execute()) {
			
			$veiculo = $stmt->get_result()->fetch_assoc();
			$stmt->close();
			return $veiculo;
		
		} else {
			
			return false;
			
		}		
		
	}
	
	
	public function enviaNovaSenha($email) {
		
		$senha_nova = substr(time(),0,8);
		$senha_nova_criptografada = $this->criptoSenha($senha_nova);
		
		if(smtpmailer($email, 'noreply@manutencaoveicular.com.br', 'Projeto Carro', 'Sua nova senha','Sua nova senha e: '.$senha_nova )) {
                    
			$stmt = $this->conn->prepare("UPDATE tb_usuario SET S_SENHA = ? WHERE S_EMAIL = ?");
            $stmt->bind_param("ss", $senha_nova_criptografada, $email);
            $result = $stmt->execute();
            $stmt->close();
            return true;
			
        } else {
			 
			return false;
			 
		}							
	}
	
	
	public function atualizaSenhaUsuario($email, $senha_antiga, $senha_nova) {
		
		$usuario = $this->obtemUsuarioPorEmailESenha($email, $senha_antiga);
		
		if($usuario) {
			
			$senha_nova_criptografada = $this->criptoSenha($senha_nova);			
			$stmt = $this->conn->prepare("UPDATE tb_usuario SET S_SENHA = ? WHERE S_EMAIL = ?");
			$stmt->bind_param("ss", $senha_nova_criptografada, $email);
			$stmt->execute();
			$stmt->close();
			return true;
			
		} else {
			
			return false;
			
		}
		
	}
	
	public function ativaUsuario($email) {
		
		$stmt = $this->conn->prepare("UPDATE tb_usuario SET B_INATIVO = 0 WHERE S_EMAIL = ?");
		$stmt->bind_param("s",$email);
		
		if($stmt->execute()) {
			
			$stmt->close();
			return true;
			
		} else {
			
			return false;
			
		}
	}
	
	public function inativaUsuario($email) {
		
		$stmt = $this->conn->prepare("UPDATE tb_usuario SET B_INATIVO = 1 WHERE S_EMAIL = ?");
		$stmt->bind_param("s",$email);
		
		if($stmt->execute()) {
			
			smtpmailer($email, 'noreply@manutencaoveicular.com.br', 'Projeto Carro', 'Desativacao de conta', 'Sua conta foi desativada com sucesso, caso necessite ativar novamente acesse o app.');
			$stmt->close();
			return true;
			
		} else {
			
			return false;
			
		}
	}
	
	public function modificaKmManualmente($placa, $km) {
		
		$stmt = $this->conn->prepare("UPDATE tb_veiculo SET N_KM = ? WHERE S_PLACA = ?");
		$stmt->bind_param("ss", $km, $placa);
		
		if($stmt->execute()) {
			
			$stmt->close();
			return true;
		
		} else {
			
			return false;
		
		}			
		
	}
	
	
	
	public function excluiVeiculo($placa) {
		
		$stmt = $this->conn->prepare("DELETE FROM tb_veiculo WHERE S_PLACA = ?");
		$stmt->bind_param("s",$placa);
		
		if($stmt->execute()) {
			
			$stmt->close();
			return true;
		} else {
			return false;
		}
		
	}
	
	
	public function verificaUsuarioInativo($email) {
		
		$stmt = $this->conn->prepare("SELECT * FROM tb_usuario WHERE S_EMAIL = ? AND B_INATIVO = 1");
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$stmt->store_result();
		
		if($stmt->num_rows > 0) {
			
			$stmt->close();
			return true;
			
		} else {
			
			$stmt->close();
			return false;
			
		}
	}
	
	public function criptoSenha($senha){
		$senha_criptografada = md5(md5($senha));
		
		return $senha_criptografada;
	}
	
	
	
	public function obtemMarcasParaSpinner() {
		
		$stmt = $this->conn->prepare("SELECT S_MARCA FROM tb_exemplos_marcas");
		$stmt->execute();
		$result = $stmt->get_result();
				
		if(!empty($result)) {
			
			if($result->num_rows > 0) {
				
				$marcas = array();				
				while($linha = $result->fetch_assoc()) {
										
					$marcas[] = $linha["S_MARCA"];
					//$marca["marca"] = $linha["S_MARCA"];
					//array_push($marcas,$marca);
				}
				$stmt->close();				
				return $marcas;
										
			} else {
				$stmt->close();
				return false;
			}
			
		} else {
			$stmt->close();
			return false;
		}				
	}
	
	public function obtemModelosPorMarcaParaSpinner($marca) {
		
		$stmt = $this->conn->prepare("SELECT ID_MARCA FROM tb_exemplos_marcas WHERE S_MARCA = ?");
		$stmt->bind_param("s",$marca);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_assoc();
		$id_marca = $result["ID_MARCA"];
		
		$stmt = $this->conn->prepare("SELECT S_MODELO FROM tb_exemplos_veiculos WHERE ID_MARCA = ?");
		$stmt->bind_param("i",$id_marca);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result->num_rows > 0) {
			
			$modelos = array();
			
			while($linha = $result->fetch_assoc()) {
				
				$modelos[] = $linha["S_MODELO"];
				
			}
			
			$stmt->close();
			return $modelos;
		
		} else {
			
			$stmt->close();
			return false;
		
		}
	}
	
	
	public function preencherMarcasNoBD() {
		
		$json_file = file_get_contents("http://fipeapi.appspot.com/api/1/carros/marcas.json");
		
		$json_str = json_decode($json_file);
		
		foreach($json_str as $registro):
			echo 'Nome: ' . $registro->name . ' - id: ' . $registro->id .'<br>';
			
			$marca = $registro->name;
			$id = $registro->id;
			
			$stmt = $this->conn->prepare("INSERT INTO tb_exemplos_marcas(S_MARCA, ID_MARCA) VALUES( ?, ?)");
			$stmt->bind_param("ss", $marca, $id);
			$stmt->execute();			
			
					
		endforeach;
		$stmt->close();
		
	}
	
	
	public function preencherModelosNoBD() {
		
	
		$stmt = $this->conn->prepare("SELECT ID_MARCA from tb_exemplos_marcas");		
		$stmt->execute();
		$result = $stmt->get_result();
		
		$qtd_marcas = $result->num_rows;
		$cont = 1;
		
		$stmt->close();
		
		while($cont < $qtd_marcas) {
			
			$stmt = $this->conn->prepare("SELECT ID_MARCA from tb_exemplos_marcas WHERE ID = ?");
			$stmt->bind_param("i",$cont);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			$linha = $result->fetch_assoc();
			
			$id_marca = $linha["ID_MARCA"];
	
			$json_file = file_get_contents("http://fipeapi.appspot.com/api/1/carros/veiculos/$id_marca.json");
		
			$json_str = json_decode($json_file);
						
			foreach($json_str as $registro):
				echo 'Nome: ' . $registro->name . ' - id: ' . $registro->id .'<br>';
				
				$modelo = $registro->name;
				$id_modelo = $registro->id;
				
				$stmt = $this->conn->prepare("INSERT INTO tb_exemplos_veiculos(S_MODELO, ID_MODELO, ID_MARCA) VALUES( ?, ?, ?)");
				$stmt->bind_param("sii", $modelo, $id_modelo, $id_marca);
				$stmt->execute();
				$stmt->close();
										
			endforeach;
			
			$cont++;
				
		}
	}
	
}