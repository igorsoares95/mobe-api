<?php
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array("error" => FALSE);
	
	if(isset($_POST['id_manutencao_do_veiculo'])) {
	
		$id_manutencao_do_veiculo = $_POST['id_manutencao_do_veiculo'];		
		
		if($bd->excluiManutencaoDoVeiculo($id_manutencao_do_veiculo)) {
			
			$response["error"] = FALSE;
			echo json_encode($response);
						
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi possível excluir a manutencão desse veículo";
			echo json_encode($response);						
		}
			
	} else {
			$response["error"] = TRUE;
			$response["error_msg"] = "Preencha todos os campos";
			echo json_encode($response);	
		
	}