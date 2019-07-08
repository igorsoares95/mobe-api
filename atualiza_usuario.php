<?php

	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	$response = array("error" => FALSE);
	
	if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['telefone'])) {
		
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$telefone = $_POST['telefone'];
		$usuario = $bd->atualizaUsuario($nome, $email, $telefone);
		
		if($usuario) {
		
			$response["error"] = FALSE;
			$response["usuario"]["id"] = $usuario["ID"];
			$response["usuario"]["nome"] = $usuario["S_NOME"];
			$response["usuario"]["email"] = $usuario["S_EMAIL"];
			$response["usuario"]["telefone"] = $usuario["N_TELEFONE"];
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Nenhuma informação foi alterada!.";
			echo json_encode($response);
			
		}
		
		
	} else {
		
		$response["error"] = TRUE;
		$response["error_msg"] = "Preencha todos os campos";
		echo json_encode($response);
		
	}


?>