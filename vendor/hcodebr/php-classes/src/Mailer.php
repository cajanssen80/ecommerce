<?php

namespace Hcode;

use Rain\Tpl;

class Mailer {

	const USERNAME = "cajanssen@gmail.com";
	const PASSWORD = "<?password?>";
	const NAME_FROM = "Hcode store";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data =  array())
	{

		$config = array(
				"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
				"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
				"debug"         => false // set to false to improve the speed
			   );
		Tpl::configure( $config );
		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);

		$this->mail = new \PHPMailer;
		$this->mail->isSMTP();
		$this->mail->SMTPDebug = 0; /*SMTP::DEBUG_SERVER;*/
		$this->mail->Host = 'smtp.gmail.com';
		$this->mail->Port = 587;
		$this->mail->SMTPSecure = 'tls';/*PHPMailer::ENCRYPTION_STARTTLS;*/
		$this->mail->SMTPAuth = true;
		$this->mail->Username = Mailer::USERNAME;
		$this->mail->Password = Mailer::PASSWORD;
		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
		$this->mail->addAddress($toAddress, $toName);
		$this->mail->Subject = $subject;
		$this->mail->msgHTML($html);
		$this->mail->AltBody = 'Nada...';
		
	}

	public function send()
	{
		return $this->mail->send();
	}

}

?>