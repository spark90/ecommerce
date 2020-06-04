<?php 

namespace Hcode;

use Rain\Tpl;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';



class Mailer{
	private $mail;

	const USERNAME = "douglasmerall89@gmail.com";
	const PASSWORD = "<?password?>";
	const NAME_FROM = "Hcode Store";

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
	    );

		Tpl::configure( $config );

		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}
	

	$html = $tpl->draw($tplName, true);



// Instantiation and passing `true` enables exceptions
	$this->mail = new PHPMailer(true);


    //Server settings
    $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $this->mail->isSMTP();                                            // Send using SMTP
    $this->mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $this->mail->Username   = Mailer::USERNAME;                     // SMTP username
    $this->mail->Password   = Mailer::PASSWORD;                   // SMTP password
    $this->mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $this->mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
    $this->mail->addAddress($toAddress, $toName);     // Add a recipient
    //$this->mail->addAddress('ellen@example.com');               // Name is optional
    

    // Attachments
    //$this->mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $this->mail->isHTML(true);                                  // Set email format to HTML
    $this->mail->Subject = $subject;
  	$this->mail->msgHTML($html); 
    $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  


}

public function send(){

	return $this->mail->send();
}
}
 ?>