<?php
use App\Models\ModelAdmin;

	if (isset($_POST['email']) && isset($_POST['new-password']) && isset($_POST['conf-password'])) {

        $password = htmlentities($_POST['new-password']);
        $confpassword = htmlentities($_POST['conf-password']);
        $mail = $_POST['email'];

        if (!preg_match('#^(?=.*?\d)(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[\#\?\!\\$%\^&\*\-]).{8,}$#', $password)) {

            $_SESSION['error_message'] = lang('TraitCRUDAdmin.password_conditions');
            header('location:' . base_url('/admin/create'));
            exit;
        }
    
        if($password != $confpassword){
            
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.password_not_similar');
            header('location:' . base_url('/admin/create'));
            exit;
        }

        $modelAdmin = model(ModelAdmin::class);
        $mailExistant = $modelAdmin->getAdminFromMail($mail);

        if($mailExistant != null){
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.email_already_used');
            header('location:' . base_url('/admin/create'));
            exit;
        }

        $modelAdmin->createAdmin($mail, $password);
        $_SESSION['valid_message'] = lang('TraitCRUDAdmin.success_create_admin');
        header('location:' . base_url('/admin'));
        exit;
        
    }

    header('location:' . base_url('/admin/login'));
    exit;
    
?>