<?php
	
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	//cria um array JSON
	$response = array("error" => FALSE);
	
	if(isset($_POST['placa_veiculo_do_usuario'])){
		
		//recebe senha e email via POST
		$placa_veiculo_do_usuario = $_POST['placa_veiculo_do_usuario'];
		
		if($bd->obtemManutencoesRecomendadas($placa_veiculo_do_usuario)) {
			
			$response["manutencoes"] = $bd->obtemManutencoesRecomendadas($placa_veiculo_do_usuario);
			$response["error"] = FALSE;			
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi encontrada manutencoes recomendadas para esse modelo";
			echo json_encode($response);
			
		}
			
	}

?>