<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/PHPMailer/src/Exception.php';
require 'vendor/phpmailer/PHPMailer/src/PHPMailer.php';
require 'vendor/phpmailer/PHPMailer/src/SMTP.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
// enable SMTP debugging
$mail->SMTPDebug = 4;
//Set the SMTP settings
$mail->isSMTP(); //Enable SMTP
$mail->Host = 'smtp.gmail.com'; //Set the SMTP server to gmail
$mail->Port = 587; //Set the SMTP port to 587
$mail->SMTPAuth = true; //Enable SMTP authentication
$mail->SMTPSecure = 'tls'; //Enable encryption, 'ssl' also accepted

//Set the authentication credentials
$mail->Username = 'oluwafeyisayofummi@gmail.com'; //Your Gmail address
$mail->Password = '1offeyicialA'; //Your Gmail password

//Set the email subject, body, and recipients
$mail->setFrom('oluwafeyisayofummi@gmail.com', 'Your Name');
$mail->addAddress('elderwaleoladipo@example.com', 'Recipient Name');
$mail->Subject = 'Test Email from PHPMailer';
$mail->Body = 'This is a test email from PHPMailer.';

//Send the email
if(!$mail->send()) {
    echo 'Error sending email: ' . $mail->ErrorInfo;
} else {
    echo 'Email sent successfully!';
}

?>
