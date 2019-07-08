<?php
require_once("phpmailer/class.phpmailer.php");

//define('GUSER', 'guilhermerodrigues73@gmail.com');	// <-- Insira aqui o seu GMail
//define('GPWD', '@Guilherme73');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	//$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'mail.manutencaoveicular.com.br';	// SMTP utilizado
	$mail->Port = 25;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = 'noreply@manutencaoveicular.com.br'; //GUSER;
	$mail->Password = 'D@aniel01'; //GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		//$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		//$error = 'Mensagem enviada!';
		return true;
	}
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
// o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

?>