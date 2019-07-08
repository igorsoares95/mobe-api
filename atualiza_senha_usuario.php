<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array("error" => FALSE);
	
	if(isset($_POST['email']) && isset($_POST['senha_antiga']) && isset($_POST['senha_nova'])) {
		
		$email = $_POST['email'];
		$senha_antiga = $_POST['senha_antiga'];
		$senha_nova = $_POST['senha_nova'];
		
		if($bd->atualizaSenhaUsuario($email, $senha_antiga, $senha_nova)) {
			
			$response["error"] = FALSE;
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Senha incorreta, tente novamente";
			echo json_encode($response);
			
		}

	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}
?>