<?php
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array("error" => FALSE);
	
	if(isset($_POST['data_ultima_manutencao']) && isset($_POST['km_ultima_manutencao']) && isset($_POST['id_manutencao_do_veiculo'])) {
		
		$data_ultima_manutencao = $_POST['data_ultima_manutencao'];
		$km_ultima_manutencao = $_POST['km_ultima_manutencao'];
		$id_manutencao_do_veiculo = $_POST['id_manutencao_do_veiculo'];

		
		if($bd->realizaManutencao($data_ultima_manutencao, $km_ultima_manutencao, $id_manutencao_do_veiculo)) {
			
			$response["error"] = FALSE;
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Manutenção nao pode ser realizada";
			echo json_encode($response);
		}
	} else {
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}