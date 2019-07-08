<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<HTML>
<HEAD>
<TITLE>Projeto Carro</TITLE>
<STYLE>
h1 { text-align: center; padding: 5px; margin: auto; font-size: 48px; color: #FFF }
div.h1 { border: 4px groove #FFF; padding: 2px; margin-top: 5px; }
div.body { border: 4px double #FFF; padding: 220px; margin-top: 5px; }
body { text-align: center; padding: 5px; font-size: 30px; background: #696969; color: #FFF}
</STYLE>
<BODY>
<DIV class="h1">
<h1>Projeto Carro</h1>
</DIV>
<DIV class="body">
<?php

    require_once 'include/Funcoes_BD.php';
    $db = new Funcoes_BD();       
    
    $email = $_GET["email"];
    $token = $_GET["token"];
    
    if($db->verificaUsuarioPorEmailEToken($email, $token)) {
        
        if($db->verificaUsuarioConfirmado($email, $token)) {
            
            echo 'Usuario ja confirmado';
           
        } else {
                        
            if($db->confirmaUsuario($email, $token)) {
			
				echo 'Usuario confirmado com sucesso';
			
			} else {
			
				echo 'Ocorreu um erro durante a confirmacao do usuario, tente novamente';
			
			}           
                          
        }
    } else {
        
        echo 'Pagina de confirmacao invalida';
    }
?>
</DIV>
</BODY>
</HTML>
