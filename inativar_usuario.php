<?php
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array("error" => FALSE);
	
	if(isset($_POST['email'])) {
	
		$email = $_POST['email'];
		
		if($bd->inativaUsuario($email)) {
			
			$response["error"] = FALSE;
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Usuario não pode ser desativado";
			echo json_encode($response);
			
		}
	
	}