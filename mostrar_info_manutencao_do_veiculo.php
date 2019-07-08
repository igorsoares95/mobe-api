<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['id_manutencao_do_veiculo'])) {
		
		$id_manutencao_do_veiculo = $_POST['id_manutencao_do_veiculo'];
		
		$manutencao = $bd->mostraInfoManutencaoDoVeiculo($id_manutencao_do_veiculo);
		
		if($manutencao) {
		
			$response["error"] = FALSE;
			$response["manutencao"]["id"] = $manutencao["ID"];
			$response["manutencao"]["descricao"] = $manutencao["S_DESCRICAO"];
			$response["manutencao"]["limite_km"] = $manutencao["N_LIMITE_KM"];
			$response["manutencao"]["limite_tempo_meses"] = $manutencao["N_LIMITE_TEMPO_MESES"];
			$response["manutencao"]["km_antecipacao"] = $manutencao["N_KM_ANTECIPACAO"];
			$response["manutencao"]["tempo_antecipacao_meses"] = $manutencao["N_TEMPO_ANTECIPACAO_MESES"];
			$response["manutencao"]["data_ultima_manutencao"] = $manutencao["D_DATA_ULTIMA_MANUTENCAO"];
			$response["manutencao"]["km_ultima_manutencao"] = $manutencao["N_KM_ULTIMA_MANUTENCAO"];
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Erro ao obter informações da manutencao";
			echo json_encode($response);
			
		}
		
		
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}


?>