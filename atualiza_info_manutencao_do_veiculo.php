<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['id_manutencao_do_veiculo']) && isset($_POST['limite_km']) && isset($_POST['limite_tempo_meses']) && isset($_POST['km_antecipacao']) && isset($_POST['tempo_antecipacao_meses']) && isset($_POST['data_ultima_manutencao']) && isset($_POST['km_ultima_manutencao'])) {
		
		$id_manutencao_do_veiculo = $_POST['id_manutencao_do_veiculo'];
		$limite_km = $_POST['limite_km'];
		$limite_tempo_meses = $_POST['limite_tempo_meses'];
		$km_antecipacao = $_POST['km_antecipacao'];
		$tempo_antecipacao_meses = $_POST['tempo_antecipacao_meses'];
		$data_ultima_manutencao = $_POST['data_ultima_manutencao'];
		$km_ultima_manutencao = $_POST['km_ultima_manutencao'];	
		
		
		if($bd->atualizaInfoManutencaoDoVeiculo($id_manutencao_do_veiculo, $limite_km, $limite_tempo_meses, $km_antecipacao, $tempo_antecipacao_meses, $data_ultima_manutencao, $km_ultima_manutencao)) {
		
			$response["error"] = FALSE;
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Nenhuma informação foi alterada!.";
			echo json_encode($response);
			
		}
		
		
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}


?>