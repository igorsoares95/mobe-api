<?php
	require_once 'include/Funcoes_BD.php';
	$bd = new Funcoes_BD();
	$response = array();

	if(isset($_POST['km']) && isset($_POST['codigo_dispositivo']) && isset($_POST['host'])) {
	
		$km = $_POST['km'];
		$codigo_dispositivo = $_POST['codigo_dispositivo'];
		$host = $_POST['host'];
		
		
		if($bd->verificaDispositivoEmUso($codigo_dispositivo)) {
			
			if($bd->gravaKmRecebidaNoLog($codigo_dispositivo, $km, $host)) {
				
				if($bd->somaKmDoVeiculo($km, $codigo_dispositivo)) {
										
					$response["manutencoes"] = $bd->notificaManutencoesAtrasadasEProximasDoUsuario($codigo_dispositivo);
					echo json_encode($response);
					return true;
					
				} else {
					
					$response["error"] = TRUE;;
					echo json_encode($response);
					return false;				
										
				}

			   
		    } else {
			   
			   $response["error"] = TRUE;;
				echo json_encode($response);
			   return false;
			   
		   }
						
		} else {
			
			$response["error"] = TRUE;;
			echo json_encode($response);
			return false;
		
		}
		
	}
        else
{
			   
			   $response["error"] = "deu erro";
				echo json_encode($response);
			   return false;
			   
		   }













