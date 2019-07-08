<?php
	
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	//cria um array JSON
	$response = array("error" => FALSE);
	
	if(isset($_POST['id_usuario'])){
		
		$id_usuario = $_POST['id_usuario'];
		
		if($bd->obtemManutencoesAtrasadasDoUsuario($id_usuario)) {
			
			$response["manutencoes_atrasadas"] = $bd->obtemManutencoesAtrasadasDoUsuario($id_usuario);
			$response["error"] = FALSE;			
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi encontrado manutencoes atrasadas para esse usuário";
			echo json_encode($response);
			
		}
			
	}

?>