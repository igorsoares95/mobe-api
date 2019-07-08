<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['codigo_dispositivo']) && isset($_POST['placa'])) {
		
		$codigo_dispositivo = $_POST['codigo_dispositivo'];
		$placa = $_POST['placa'];
				
		if($bd->verificaDispositivoExistente($codigo_dispositivo)) {
					
			if($bd->verificaDispositivoAtivo($codigo_dispositivo)) {
				
				if(!$bd->verificaDispositivoEmUso($codigo_dispositivo)) {
													
					if($bd->modificaDispositivoDoVeiculo($codigo_dispositivo, $placa)) {
				
						$response["error"] = FALSE;
						echo json_encode($response);
				
					} else {
						
						$response["error"] = TRUE;
						$response["error_msg"] = "Erro durante o troca de dispositivo";
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
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}


?>