<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['placa_veiculo_usuario']) && isset($_POST['descricao']) && isset($_POST['limite_km']) && isset($_POST['limite_tempo_meses']) && isset($_POST['km_antecipacao']) && isset($_POST['tempo_antecipacao']) && isset($_POST['data_ultima_manutencao']) && isset($_POST['km_ultima_manutencao']) ){
		
		$placa_veiculo_usuario = $_POST['placa_veiculo_usuario'];
		$descricao = $_POST['descricao'];
		$limite_km = $_POST['limite_km'];
		$limite_tempo_meses = $_POST['limite_tempo_meses'];
		$km_antecipacao = $_POST['km_antecipacao'];
		$tempo_antecipacao = $_POST['tempo_antecipacao'];
		$data_ultima_manutencao = $_POST['data_ultima_manutencao'];
		$km_ultima_manutencao = $_POST['km_ultima_manutencao'];
		
		if($bd->criaManutencaoPersonalizadaDoVeiculo($placa_veiculo_usuario, $descricao, $limite_km, $limite_tempo_meses, $km_antecipacao, $tempo_antecipacao, $data_ultima_manutencao, $km_ultima_manutencao)) {
	
			$response["error"] = FALSE;
			echo json_encode($response);
					
		} else {
		
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi possível criar a manutencão personalizada";
			echo json_encode($response);			
		
		}
					
			
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}

?>