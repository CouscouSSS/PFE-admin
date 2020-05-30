<?php

session_start();

$to = "alonsokhalil@gmail.com";
$from = htmlentities($_REQUEST['email']);
$name = htmlentities($_REQUEST['name']);
$subject = htmlentities($_REQUEST['subject']);
$cmessage = htmlentities($_REQUEST['message']);

$headers = "From: $from";
$headers = "From: " . $from . "\r\n";
$headers .= "Reply-To: " . $from . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


$logo = './img/2.png';

$body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body style=\"text-center \">";
$body .= "<table style='width: 100%;'>";
$body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
$body .= "</td></tr></thead><tbody><tr>";
$body .= "<td style='border:none;'><strong>Name:</strong> {$name}</td>";
$body .= "<td style='border:none;'><strong>Email:</strong> {$from}</td>";
$body .= "</tr>";
$body .= "<tr><td style='border:none;'><strong>Subject:</strong> {$subject}</td></tr>";
$body .= "<tr><td></td></tr>";
$body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
$body .= "</tbody></table>";
$body .= "</body></html>";

if(!empty($subject) && !empty($name) && !empty($cmessage) && !empty($from)){
    $send = mail($to, $subject, $body, $headers);
}

if($send){
    $_SESSION['flash']['success']="Votre message a été envoyé merci de nous avoir contacté";
    header('Location:index.php');
}
else{
    $_SESSION['flash']['danger']="Une erreur a interempu l'envoi du message merci de résseayer";
    header('Location:index.php');
}

?>