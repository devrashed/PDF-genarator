<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

//require 'vendor/autoload.php';

require('tcpdf/tcpdf.php');

$name = $_POST['name'];
$course = $_POST['course'];
$email = $_POST['email'];

$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', true);

$pdf->SetTitle('');

$pdf->AddPage();

$pdf->SetFont('helvetica', '');
$pdf->writeHTML
("
 <h1> name List </h1>
<table style='background-color: azure; width:100%;'>
        <tr>
        <td>Name</td>
        <td>Course </td>
        <td>Email</td>
        </tr>  
        <tr>
        <td>$name</td>
        <td>$course </td>
        <td>$email</td>
        </tr>  
   </table>
");



//$pdf->Output($name.'-'.$course.'-'.'certificate.pdf', 'D');
$pdf = $pdf->Output('', 'S');

$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.itr.works';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'admin@itr.works';                     //SMTP username
    $mail->Password   = 'itrrashed@90';                               //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    

    //Recipients
    $mail->setFrom('email@itr.works', 'Rashed khan');
    $mail->addAddress($email, '');     //Add a recipient


    //Attachments
     $mail->addStringAttachment($pdf, 'attchatment.pdf');
     
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //$mail->send();
    //echo 'Message has been sent';
    if ($mail->send()) {
    echo 'Email sent successfully';
} else {
    echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}