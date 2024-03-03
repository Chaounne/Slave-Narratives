<?php

    require ('../PHPMailer/src/Exception.php');
    require ('../PHPMailer/src/PHPMailer.php');
    require ('../PHPMailer/src/SMTP.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use App\Models\ModelAdmin;

    if (isset($_POST['current-password']) && isset($_POST['new-password']) && isset($_POST['conf-password'])) {

        $password = $_POST['new-password'];
        $currentpassword = htmlentities($_POST['current-password']);
        $confpassword = htmlentities($_POST['conf-password']);

        $modelAdmin = model(ModelAdmin::class);
        $admin = $modelAdmin->getAdminFromId($_SESSION['idAdmin']);

        if(!password_verify($currentpassword, $admin['password'])){

            $_SESSION['error_message'] = lang('TraitCRUDAdmin.current_password');
            header('location:' . base_url('/admin/editPassword'));
            exit;
        }

        if (!preg_match('#^(?=.*?\d)(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[\#\?\!\\$%\^&\*\-]).{8,}$#', $password)) {

            $_SESSION['error_message'] = lang('TraitCRUDAdmin.password_conditions');
            header('location:' . base_url('/admin/editPassword'));
            exit;
        }
    
        if($password != $confpassword){
            
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.password_not_similar');
            header('location:' . base_url('/admin/editPassword'));
            exit;
        }

        $id = $_SESSION['idAdmin'];

        $mailEdit = new PHPMailer(); $mailEdit->IsSMTP(); $mailEdit->Mailer = "smtp";

        try {
            // Server settings
            $mailEdit->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debugging
            $mailEdit->isSMTP();
            $mailEdit->Host = $_ENV["MAIL_HOST"];
            $mailEdit->SMTPAuth = true;
            $mailEdit->Username = $_ENV["MAIL_USERNAME"];
            $mailEdit->Password = $_ENV["MAIL_PASSWORD"];
            $mailEdit->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mailEdit->Port = $_ENV["MAIL_PORT"];
        
            // Recipients
            $mailEdit->setFrom('siteweb.slave.narratives@gmail.com', 'Site web - Slave Narratives');
            $mailEdit->addAddress($admin['email']);
        
            // Content
            $mailEdit->isHTML(true);
            $mailEdit->Subject = mb_convert_encoding(lang('TraitCRUDAdmin.update_password_title'), 'ISO-8859-1', 'UTF-8');
            $mailEdit->Body = '<p>'.lang('TraitCRUDAdmin.content_email_edit_password').'<br>'.
                                lang('TraitCRUDAdmin.if_update_mail').'</p>';
        
            $mailEdit->send();

            // Method
            $modelAdmin->updatePassword($password, $id);

            $_SESSION['password_oublie_message'] = lang('TraitCRUDAdmin.update');
            unset($_SESSION['idAdmin']);
            setcookie('token', '', 0, '/');
            header('location:' . base_url('/admin/login'));
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.error');
            header('location:' . base_url('/admin/editPassword'));
            exit;
        }
        
    }

    header('location:' . base_url('/admin/login'));
    exit;
    
?>