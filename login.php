<?php
	
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	//cria um array JSON
	$response = array("error" => FALSE);
	
	if( isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['reg_id']) ){
		
		//recebe senha e email e reg_id via POST
		$email = $_POST['email'];
		$senha = $_POST['senha'];
		$reg_id = $_POST['reg_id'];
		$usuario = $bd->obtemUsuarioPorEmailESenha($email, $senha);
		
		if($usuario){
			
			if($usuario['B_CONFIRMACAO']) {
				
				if(!$bd->verificaUsuarioInativo($email)) {
				
					if($bd->gravaRedIdFirebaseDoUsuario($email,$reg_id)) {	
							
						$response["error"] = FALSE;
						$response["usuario"]["id"] = $usuario["ID"];
						$response["usuario"]["nome"] = $usuario["S_NOME"];
						$response["usuario"]["email"] = $usuario["S_EMAIL"];
						$response["usuario"]["telefone"] = $usuario["N_TELEFONE"];			
						echo json_encode($response);
											
					
					} else {
						
						$response["error"] = TRUE;
						$response["usuario"]["inativo"] = $usuario["B_INATIVO"];
						$response["error_msg"] = "Não foi possível armazenar o Reg ID do Usuario";
						echo json_encode($response);					
											
					}

				} else {
					
					$response["error"] = TRUE;			
					$response["usuario"]["email"] = $usuario["S_EMAIL"];
					$response["usuario"]["inativo"] = $usuario["B_INATIVO"];
					$response["error_msg"] = "Usuario inativo";
					echo json_encode($response);					
										
				}
				
			} else {
				
				if($bd->enviaEmailConfirmacao($email, $senha)){
					
					$response["error"] = TRUE;
					$response["usuario"]["inativo"] = $usuario["B_INATIVO"];
					$response["error_msg"] = "Usuário não confirmado, um link de confirmação foi enviado para seu email";
					echo json_encode($response);
					
				} else {
					
					$response["error"] = TRUE;
					$response["usuario"]["inativo"] = $usuario["B_INATIVO"];
					$response["error_msg"] = "Houve uma falha no Login, tente novamente.";
					echo json_encode($response);
					
				}
				
			}
			
		} else {
			
			//usuário não encontrado
			$response["error"] = TRUE;
			$response["error_msg"] = "Dados incorretos, tente novamente";
			echo json_encode($response);
						
		}
		
	} else {
		//parametros não preenchidos
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos!";
		echo json_encode($response);
	}

?>