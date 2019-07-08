<?php
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array("error" => FALSE);
	
	if(isset($_POST['placa_veiculo_do_usuario']) && isset($_POST['id_manutencao_padrao'])) {
	
		$placa_veiculo_do_usuario = $_POST['placa_veiculo_do_usuario'];
		$id_manutencao_padrao = $_POST['id_manutencao_padrao'];

		if($bd->excluiManutencaoRecomendadaDoVeiculo($placa_veiculo_do_usuario, $id_manutencao_padrao)) {
			
			$response["error"] = FALSE;
			echo json_encode($response);
						
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi possível excluir a manutencão recomendada desse veículo";
			echo json_encode($response);						
		}
			
	} else {
			$response["error"] = TRUE;
			$response["error_msg"] = "Preencha todos os campos";
			echo json_encode($response);	
		
	}