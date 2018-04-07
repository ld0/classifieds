<!-- Send emails. -->

<?php

	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/structure/header.php');
	require_once ($_SERVER['DOCUMENT_ROOT'] . './includes/structure/footer.php');

	// Display errors - turn off in production.
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    	require_once('class.phpmailer.php');
	require_once('PHPMailerAutoload.php');
	function sendmail($to,$subject,$message,$name,$isconf){
        	$mail             = new PHPMailer();
		$mail->IsHTML(true);
		if ($isconf){
	 		$body             = "<p><b>Thank you</b> for submitting a post to UNO Classifieds! Click ";
			$body .= "<a href='$message'>HERE</a>";
			$body .= " to confirm your post.</p>";
			$alt = "Thank you for submitting a post to UNO Classifieds! Visit $message to confirm your post.";
		}
		else{
			$body = "<p>Your post $message has been deleted from UNO Classifieds for breaking the rules. Please note that <b>spam</b>, <b>scams</b>, and all <b>illegal services</b> are prohibited from the site. UNO Classifieds is a community run service and we work together to keep it safe for everyone.</p>";
			$alt = "Your post $message has been deleted from UNO Classifieds for breaking the rules. Please note that spam, scams, and all illegal services are prohibited from the site. UNO Classifieds is a community run service and we work together to keep it safe for everyone.";
		}
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;
		$mail->Host       = "smtp.gmail.com";
		$mail->Port       = 587;
		$mail->Username   = "unoclassifieds@gmail.com";
		$mail->Password   = "xxxxxxxxxx";
		$mail->SMTPSecure = 'tls';
		$mail->SetFrom('unoclassifieds@gmail.com', 'UNO Classifieds');
 		$mail->AddReplyTo("unoclassifieds@gmail.com","UNO Classifieds");
		$mail->Subject    = $subject;
		// AltBody if the recipient's email service is not processing HTML
		$mail->AltBody    = $alt;
		$mail->MsgHTML($body);
		$mail->IsHTML(true);
		$address = $to;
		$mail->AddAddress($address, $name);
		if(!$mail->Send()){
			//echo "success";
			return 0;
                  } else {
			//echo "failure";
                        return 1;
                 }
    }

?>
