<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['placa_veiculo_usuario']) && isset($_POST['id_manutencao_padrao']) && isset($_POST['km_antecipacao']) && isset($_POST['tempo_antecipacao']) && isset($_POST['data_ultima_manutencao']) && isset($_POST['km_ultima_manutencao']) ){
		
		$placa_veiculo_usuario = $_POST['placa_veiculo_usuario'];
		$id_manutencao_padrao = $_POST['id_manutencao_padrao'];
		$km_antecipacao = $_POST['km_antecipacao'];
		$tempo_antecipacao = $_POST['tempo_antecipacao'];
		$data_ultima_manutencao = $_POST['data_ultima_manutencao'];
		$km_ultima_manutencao = $_POST['km_ultima_manutencao'];
		
		if($bd->criaManutencaoRecomendadaDoVeiculo($placa_veiculo_usuario, $id_manutencao_padrao, $km_antecipacao, $tempo_antecipacao, $data_ultima_manutencao, $km_ultima_manutencao)) {
	
			$response["error"] = FALSE;
			echo json_encode($response);
					
		} else {
		
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi possível criar a manutencão recomendada";
			echo json_encode($response);			
		
		}
					
			
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}

?>