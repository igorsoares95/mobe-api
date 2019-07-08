<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['telefone']) && isset($_POST['senha'])){
		
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$telefone = $_POST['telefone'];
		$senha = $_POST['senha'];
		
		//checa se o usuario existe		
		if($bd->verificaUsuarioExistente($email)) {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Usuario existente " .$email;
			echo json_encode($response);
			
		} else {
			
			if($bd->armazenaUsuario($nome, $email, $telefone, $senha)) {
				
				$response["error"] = FALSE;
				echo json_encode($response);
				
			} else {
				
				$response["error"] = TRUE;
				$response["error_msg"] = "Erro durante o cadastro";
				echo json_encode($response);
				
			}
		}
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}




?>