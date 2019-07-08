<?php
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array("error" => FALSE);
	
	if(isset($_POST['placa'])) {
	
		$placa = $_POST['placa'];
		
		
		if($bd->verificaVeiculoExistente($placa)) {
			
			if($bd->excluiVeiculo($placa)) {
			
				$response["error"] = FALSE;
				echo json_encode($response);
			
			} else {
				
				$response["error"] = TRUE;
				$response["error_msg"] = "Veiculo não pode ser excluido";
				echo json_encode($response);
				
			}
						
		} else {
			
				$response["error"] = TRUE;
				$response["error_msg"] = "Veiculo nao existe";
				echo json_encode($response);						
		}
			
	}