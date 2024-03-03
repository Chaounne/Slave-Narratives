<?php
    if (isset($_SESSION['idAdmin'])) {
        header('location:' . base_url('/'));
        exit();
    }

    // Récupérer le message d'erreur s'il existe
    $error_password_oublie = isset($_SESSION['error_password_oublie']) ? $_SESSION['error_password_oublie'] : '';
    // Effacer la variable de session pour ne pas afficher le message d'erreur à chaque fois
    unset($_SESSION['error_password_oublie']);

    if (!empty($error_password_oublie)) {
        echo('<p class="error-password-oublie">'.$error_password_oublie.'</p>');
    }

?>

<div class="form">

    <form method="post" action="<?= base_url('/admin/traitForgotPassword') ?>">

        <h3><?= lang('CRUDAdmin.password_forgotten') ?></h3>
        
        <label for="mail"><?= lang('CRUDAdmin.email') ?></label>
        <input type="email" class="subform-inputs" placeholder="<?= lang('CRUDAdmin.email') ?>" name="mail" required/>

        <input type="submit" id="button-admin" name="Envoyer" value="<?= lang('CRUDAdmin.send') ?>">

    </form>

</div>