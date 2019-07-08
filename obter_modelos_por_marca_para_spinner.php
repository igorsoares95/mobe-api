<?php
	
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	//cria um array JSON
	$response = array();
	
	if(isset($_POST['id_marca'])){
		
		//recebe senha e email via POST
		$id_marca = $_POST['id_marca'];
		
		
		if($bd->obtemModelosPorIDMarcaParaSpinner($id_marca)) {
			$response["modelos"] = $bd->obtemModelosPorIDMarcaParaSpinner($id_marca);		
			echo json_encode($response);
			
		} else {
			
			$response = null;
			echo json_encode($response);
		}

			
			
			
			
	}

?>