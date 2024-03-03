<?php

    session_start();

    require ('../PHPMailer/src/Exception.php');
    require ('../PHPMailer/src/PHPMailer.php');
    require ('../PHPMailer/src/SMTP.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use App\Models\ModelAdmin;

    if(isset($_POST['mail']) && $admin != null && $_POST['mail'] == $admin['email']) {

        $token = uniqid();
        $_SESSION['token'] = $token;
        $url = "https://slave-narratives.univ-tlse2.fr/admin/token?token=$token";

        $modelAdmin = model(ModelAdmin::class); //Je ne sais pas comment faire la passerelle avec le contrôleur pour l'utiliser là-bas

        $mail = new PHPMailer(); $mail->IsSMTP(); $mail->Mailer = "smtp";

        try {
            // Method
            $modelAdmin->setToken($token, $admin['email']);

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
            $mail->setFrom('siteweb.slave.narratives@gmail.com', 'Site web - Slave Narratives');
            $mail->addAddress($admin['email']);
        
            // Content
            $mail->isHTML(true);
            $mail->Subject = mb_convert_encoding(lang('TraitCRUDAdmin.forgot_password'), 'ISO-8859-1', 'UTF-8');
            $mail->Body = '<p>'.lang('TraitCRUDAdmin.content_email_password').' '.$url.'</p>';
        
            $mail->send();

            $_SESSION['password_oublie_message'] = lang('TraitCRUDAdmin.send_mail');
            header('location:' . base_url('/admin/login'));
            exit;
        } catch (Exception $e) {
            $_SESSION['error_password_oublie'] = lang('TraitCRUDAdmin.error');
            header('location:' . base_url('/admin/forgotPassword'));
            exit;
        }
    
    } else {
        $_SESSION['error_password_oublie'] = lang('TraitCRUDAdmin.no_existing_mail');
    }

    header('location:' . base_url('/admin/forgotPassword'));
    exit;

?>
