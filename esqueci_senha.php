<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array("error" => FALSE);
	
	if(isset($_POST['email'])) {
		
		$email = $_POST['email'];
		
		if($bd->verificaUsuarioExistente($email)) {
			
			if($bd->enviaNovaSenha($email)) {
				
				$response["error"] = FALSE;
				echo json_encode($response);
								
			} else {
				
				$response["error"] = TRUE;
				$response["error_msg"] = "Falha no envio do email";
				echo json_encode($response);
				
			}
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Usuário não existente, insira um endereço de email válido";
			echo json_encode($response);
			
		}
		
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha o campo de email";
		echo json_encode($response);
		
	}
	
?>