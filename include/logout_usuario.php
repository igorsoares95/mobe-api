<?php
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array("error" => FALSE);
	
	if(isset($_POST['email'])) {
	
		$email = $_POST['email'];
		
		if($bd->removeRegIdFirebaseDoUsuario($email)) {
			$bd->informaUsuarioDeslogado($email);
			$response["error"] = FALSE;
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi possivel fazer o logout desse usuário";
			echo json_encode($response);
			
		}
	
	}