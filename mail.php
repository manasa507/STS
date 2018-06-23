 <?php
session_start();

include_once 'phpmailer/class.phpmailer.php';
$mail = new PHPMailer;

$recipient = $_SESSION['email'];
$mailMsg = "click this url for pasword reset ".$_SESSION['emailMsg']."  token is :".$_SESSION['token'];


// SMTP configuration
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'sreedazzler@gmail.com';
$mail->Password = 'exhausting';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('sreedazzler@gmail.com', 'Reset');
$mail->addReplyTo('sreedazzler@gmail.com', 'Reset');

// Add a recipient
$mail->addAddress($recipient);

// // Email subject
$mail->Subject = 'Reset password';

// Set email format to HTML
$mail->isHTML(true);

// Email body content
$mailContent = $mailMsg;
$mail->Body = $mailContent;

// Send email
if(!$mail->send())
{
    echo "<script>alert('Message could not be sent.Mailer Error: ' . $mail->ErrorInfo);
    window.location='forgotpassword.php'</script>";

}
else
{
    echo "<script>alert('Message has been sent. Check your email to reset password'); 
    window.location='https://gmail.com'</script>";
    
}
$mail->addAddress($recipient);

?>