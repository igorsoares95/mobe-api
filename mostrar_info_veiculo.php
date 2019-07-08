<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['placa']) && isset($_POST['id_usuario'])) {
		
		$placa = $_POST['placa'];
		$id_usuario = $_POST['id_usuario'];
				
		$veiculo = $bd->mostraInfoVeiculo($placa, $id_usuario);
		
		if($veiculo) {
		
			$response["error"] = FALSE;
			$response["veiculo"]["id"] = $veiculo["ID"];
			$response["veiculo"]["ano"] = $veiculo["D_ANO"];
			$response["veiculo"]["placa"] = $veiculo["S_PLACA"];
			$response["veiculo"]["km"] = $veiculo["N_KM"];
			$response["veiculo"]["codigo_dispositivo"] = $veiculo["S_CODIGO"];
			$response["veiculo"]["modelo"] = $veiculo["S_MODELO"];
			$response["veiculo"]["marca"] = $veiculo["S_MARCA"];
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Erro ao obter informações do veículo";
			echo json_encode($response);
			
		}
		
		
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}


?>