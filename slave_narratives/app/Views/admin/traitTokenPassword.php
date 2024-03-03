<?php
use App\Models\ModelAdmin;

    // Récupérer le mail du token s'il existe
    $mail = isset($_SESSION['mail_token']) ? $_SESSION['mail_token'] : '';
    // Effacer la variable de session pour ne pas afficher le mail du token à chaque fois
    unset($_SESSION['mail_token']);

    // Récupérer le mail du token s'il existe
    $token = isset($_SESSION['token']) ? $_SESSION['token'] : '';

    $passwordMembre = htmlentities($_POST['new-password-modif']);
    $confpassword = htmlentities($_POST['conf-password-modif']);

    if (!preg_match('#^(?=.*?\d)(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[\#\?\!\\$%\^&\*\-]).{8,}$#', $passwordMembre)) {

        $_SESSION['message_error_token'] = lang('TraitCRUDAdmin.password_conditions');
        header('location:' . base_url('/admin/token?token=' . $token));
        exit;

    }

    if($passwordMembre != $confpassword){
        
        $_SESSION['message_error_token'] = lang('TraitCRUDAdmin.password_not_similar');
        header('location:' . base_url('/admin/token?token=' . $token));
        exit;

    }

    $modelAdmin = model(ModelAdmin::class);
    $modelAdmin->updatePasswordByMail($mail, $passwordMembre);

    unset($_SESSION['token']);

    $_SESSION['modif-password'] = lang('TraitCRUDAdmin.update') ;
    header('location:' . base_url('/admin/login'));
    exit;

?>