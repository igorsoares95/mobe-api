<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['ano']) && isset($_POST['placa']) && isset($_POST['km']) && isset($_POST['id_usuario']) && isset($_POST['codigo_dispositivo']) && isset($_POST['id_modelo_veiculo'])){
		
		$ano = $_POST['ano'];
		$placa = $_POST['placa'];
		$km = $_POST['km'];
		$id_usuario = $_POST['id_usuario'];
		$codigo_dispositivo = $_POST['codigo_dispositivo'];
		$id_modelo_veiculo = $_POST['id_modelo_veiculo'];
				
		//checa se o veiculo existe		
		if($bd->verificaVeiculoExistente($placa)) {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Veiculo já existente ";
			echo json_encode($response);
			
		} else {
			
			if($bd->verificaUsuarioExistentePeloID($id_usuario)){
				
				if($bd->verificaDispositivoExistente($codigo_dispositivo)) {
					
					if($bd->verificaDispositivoAtivo($codigo_dispositivo)) {
						
						if(!$bd->verificaDispositivoEmUso($codigo_dispositivo)) {
															
							if($bd->armazenaVeiculo($ano, $placa, $km, $id_usuario, $codigo_dispositivo, $id_modelo_veiculo)) {
						
								$response["error"] = FALSE;
								echo json_encode($response);
						
							} else {
								
								$response["error"] = TRUE;
								$response["error_msg"] = "Erro durante o cadastro";
								echo json_encode($response);
								
							}
						} else {
							
							$response["error"] = TRUE;
							$response["error_msg"] = "Dispositivo está em uso";
							echo json_encode($response);							
							
						}
						
					} else {
						
						$response["error"] = TRUE;
						$response["error_msg"] = "Dispositivo não está ativo";
						echo json_encode($response);						
										
					}
				} else {
					
					$response["error"] = TRUE;
					$response["error_msg"] = "Dispositivo não existe";
					echo json_encode($response);					
					
				}
				
			} else {
				
				$response["error"] = TRUE;
				$response["error_msg"] = "Usuário não existente";
				echo json_encode($response);								
			}
		}
			
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}

?>