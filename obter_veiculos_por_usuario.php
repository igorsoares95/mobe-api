<?php
	
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	//cria um array JSON
	$response = array("error" => FALSE);
	
	if(isset($_POST['id_usuario'])){
		
		//recebe senha e email via POST
		$id_usuario = $_POST['id_usuario'];
		
		if($bd->obtemVeiculosPorUsuario($id_usuario)) {
			
			$response["veiculos"] = $bd->obtemVeiculosPorUsuario($id_usuario);
			$response["error"] = FALSE;			
			echo json_encode($response);
			
		} else {
			
			$response["error"] = TRUE;
			$response["error_msg"] = "Não foi encontrado veículos para esse usuário";
			echo json_encode($response);
			
		}
			
	}

?>