<?php

    require ('../PHPMailer/src/Exception.php');
    require ('../PHPMailer/src/PHPMailer.php');
    require ('../PHPMailer/src/SMTP.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use App\Models\ModelAdmin;

    if (isset($_POST['email'])) {

        $inputMail = $_POST['email'];

        $modelAdmin = model(ModelAdmin::class);
        
        $mailExistant = $modelAdmin->getAdminFromMail($inputMail);
        $oldAdminAccount = $modelAdmin->getAdminFromId($_SESSION['idAdmin']);

        if($mailExistant != null){
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.email_already_used');
            header('location:' . base_url('/admin/editMail'));
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
            $mailEdit->addAddress($oldAdminAccount['email']);
        
            // Content
            $mailEdit->isHTML(true);
            $mailEdit->Subject = mb_convert_encoding(lang('TraitCRUDAdmin.update_mail_title'), 'ISO-8859-1', 'UTF-8');
            $mailEdit->Body = '<p>'.mb_convert_encoding(lang('TraitCRUDAdmin.content_updating_email'), 'ISO-8859-1', 'UTF-8').' '.$inputMail.'<br>'
                               .lang('TraitCRUDAdmin.if_update_mail').'</p>';
        
            $mailEdit->send();

            // Method
            $modelAdmin->updateMail($inputMail, $id);

            $_SESSION['password_oublie_message'] = lang('TraitCRUDAdmin.update');
            unset($_SESSION['idAdmin']);
            setcookie('token', '', 0, '/');
            header('location:' . base_url('/admin/login'));
            exit;
        } catch (Exception $e) {
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.error');
            header('location:' . base_url('/admin/editMail'));
            exit;
        }
        
    }

    header('location:' . base_url('/admin/login'));
    exit;
    
?>