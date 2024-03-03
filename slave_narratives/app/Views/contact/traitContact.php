<?php

require ('../Libs/PHPMailer/src/Exception.php');
require ('../Libs/PHPMailer/src/PHPMailer.php');
require ('../Libs/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);

    if(!($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['last_name']) && $_POST['last_name'] != "" && isset($_POST['first_name']) && $_POST['first_name'] != "" &&
        isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['subject']) && $_POST['subject'] != "" && isset($_POST['message']) && $_POST['message'] != "" )) {

        $_SESSION['erreur-contact'] = lang('TraitContact.fields');
        header('location:' . base_url('/contact'));
        exit;
    }

    $_SESSION['contact_values'] = $_POST;
    $last_name = htmlspecialchars($_POST['last_name']);
    $first_name = htmlspecialchars($_POST['first_name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlentities($_POST['subject']);
    $message = htmlentities($_POST['message']);

    if (!preg_match("#^[\p{L}'\-\s]+$#u", $last_name)) {
        $_SESSION['erreur-contact'] = lang('TraitContact.error-l_name');
        header('location:' . base_url('/contact'));
        exit; 
    }

    if (!preg_match("#^[\p{L}'\-\s]+$#u", $first_name)) {
        $_SESSION['erreur-contact'] = lang('TraitContact.error-f_name');
        header('location:' . base_url('/contact'));
        exit; 
    }

    if (!preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $email)) {
        $_SESSION['erreur-contact'] = lang('TraitContact.error_email');
        header('location:' . base_url('/contact'));
        exit; 
    }

    $mail = new PHPMailer(); $mail->IsSMTP(); $mail->Mailer = "smtp";

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debugging
        $mail->isSMTP();
        $mail->Host = $_ENV["MAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV["MAIL_USERNAME"];
        $mail->Password = $_ENV["MAIL_PASSWORD"];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV["MAIL_PORT"];
    
        // Recipients
        $mail->setFrom($_ENV["MAIL_USERNAME"], 'Site web - Slave Narratives');
        $mail->addAddress($_ENV["MAIL_TO"], 'Slave Narratives');
    
        // Content
        $mail->isHTML(true);
        $mail->Subject = lang('TraitContact.title') . " - " . mb_convert_encoding($subject, 'ISO-8859-1', 'UTF-8');
        $mail->Body = '<p>'.lang('TraitContact.content_email').' <strong>'.$last_name.' '.$first_name.' : </strong></p>
                    <p><strong>'.lang('TraitContact.email').' : </strong>'.$email.'</p>
                    <p><strong>'.lang('TraitContact.message').' : </strong></p>
                    <p>'. nl2br($message) .'</p>';
    
        $mail->send();
        $_SESSION['msg-contact'] = lang('TraitContact.email_send');
    } catch (Exception $e) {
        $_SESSION['erreur-contact'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    unset($_SESSION['contact_values']);

    header('location:' . base_url('/contact'));
    exit;

?>
