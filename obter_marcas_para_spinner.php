<?php
	
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	
	//cria um array JSON
	$response = array();
		
	$response["marcas"] = $bd->obtemMarcasParaSpinner();		
	echo json_encode($response);
			

?>