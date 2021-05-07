<?php

	require './Bibliotecas/PHPMailer/Exception.php';
	require './Bibliotecas/PHPMailer/OAuth.php';
	require './Bibliotecas/PHPMailer/PHPMailer.php';
	require './Bibliotecas/PHPMailer/POP3.php';
	require './Bibliotecas/PHPMailer/SMTP.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;



	class Mensagem
	{
		
		private $para = null;
		private $assunto = null;
		private $mensagem = null;		
	

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		public function mensagemValida(){
			
			if(empty($this->para)||empty($this->assunto)||empty($this->mensagem)){
				return false;
			}

			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('para',$_POST['para']);
	$mensagem->__set('assunto',$_POST['assunto']);
	$mensagem->__set('mensagem',$_POST['mensagem']);

	if(!($mensagem->mensagemValida())){
		echo 'Mensagem Invalida';
		die();
	}

	$mail = new PHPMailer(true);

	try {
	    //Server settings
	    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
	    $mail->isSMTP();                                            //Send using SMTP
	    $mail->Host       = 'localhost';                     //Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	    $mail->Username   = 'webcompleto@gmail.com';                     //SMTP username
	    $mail->Password   = '1234';                               //SMTP password
	    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = 25;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom('webcompleto@gmail.com', 'Web Completo Remetente');
	    $mail->addAddress($mensagem->__get('para'));     //Add a recipient
	    //$mail->addAddress('ellen@example.com');               //Name is optional
	    // $mail->addReplyTo('info@example.com', 'Information');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

	    //Content
	    $mail->isHTML(true);                                  //Set email format to HTML
	    $mail->Subject = $mensagem->__get('assunto');
	    $mail->Body    = $mensagem->__get('mensagem');
	    $mail->AltBody = 'Necessario usar um client HTML para acesso dessa mensagem';

	    $mail->send();
	    echo 'Email enviado com sucesso';
	} catch (Exception $e) {
	    echo "Não foi possível enviar a mensagem. Erro Retornado: {$mail->ErrorInfo}";
	}




?>