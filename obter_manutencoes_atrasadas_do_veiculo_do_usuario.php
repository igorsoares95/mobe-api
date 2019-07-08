<?php
	
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	//cria um array JSON
	$response = array("error" => FALSE);
	
	if(isset($_POST['id_veiculo_do_usuario'])){
		
		$id_veiculo_do_usuario = $_POST['id_veiculo_do_usuario'];
		
		if($bd->obtemManutencoesAtrasadasDoVeiculoDoUsuario($id_veiculo_do_usuario)) {
			
			$response["manutencoes_atrasadas"] = $bd->obtemManutencoesAtrasadasDoVeiculoDoUsuario($id_veiculo_do_usuario);
			$response["error"] = FALSE;			
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi encontrado manutencoes atrasadas para esse veículo";
			echo json_encode($response);
			
		}
			
	}

?>