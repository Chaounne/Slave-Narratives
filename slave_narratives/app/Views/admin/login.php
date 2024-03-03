<?php
if (isset($_SESSION['idAdmin'])) {
    header('location:' . base_url('admin'));
    exit();
}

// Récupérer le message d'erreur s'il existe
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
// Récupérer le message de mail s'il existe
$password_oublie_message = isset($_SESSION['password_oublie_message']) ? $_SESSION['password_oublie_message'] : '';
// Récupérer le message de modification de password
$modif_password = isset($_SESSION['modif-password']) ? $_SESSION['modif-password'] : '';
// Effacer la variable de session pour ne pas afficher le message d'erreur à chaque fois
unset($_SESSION['error_message']);
// Effacer la variable de session pour ne pas afficher le message de mail à chaque fois
unset($_SESSION['password_oublie_message']);
// Effacer la variable de session pour ne pas afficher le message de modif de password à chaque fois
unset($_SESSION['modif-password']);
?>

<?php 

    if (!empty($error_message)) {
        echo('<br><p class="error-message-connexion">'.$error_message.'</p><br>');
    }
    if (!empty($password_oublie_message)) {
        echo('<br><p class="valid-message">'.$password_oublie_message.'</p><br>');
    } 
    if (!empty($modif_password)) {
        echo('<br><p class="valid-message">'.$modif_password.'</p><br>');
    } 
?>

<div class="form-container">

    <img id="parchemin-form" src="<?= base_url(); ?>/resources/login_parchment.png" alt="Parchemin">

    <form class="form-admin" method="POST" action="<?= base_url('/admin/traitLogin'); ?>">

        <div class="subform-admin-row">
            <div class="subform-cells"><input class="subform-inputs" type="text" placeholder="<?= lang('Login.email') ?>" name="mail" required></div>
            <div class="subform-cells">
                <label id="checkboxLabel">
                    <input id="checkbox-admin" type="checkbox" id="remember-me" name="rememberme" checked>
                    <svg id="checkboxCheck">
                        <polyline points="17 6 9 17 4 12"></polyline>
                    </svg>
                </label>
                <label for="remember-me"><?= lang('Login.remember_me') ?></label>
            </div>
        </div>

        <div class="subform-admin-row">
            <div class="subform-cells password-container">
                <input class="subform-inputs" type="password" id="toggle_password"placeholder="<?= lang('Login.password') ?>" name="password" required>
                <i class="far fa-eye" id="toggle_password_icon"></i>
            </div>
            <div class="subform-cells">
                <a id="forgot-password" href="<?= site_url()."admin/forgotPassword" ?>"><?= lang('Login.forgot_password') ?></a>
            </div>
        </div>   
        
        <div class="subform-admin-row">
            <div class="subform-cells">
                <input id="button-admin" type="submit" name="connexion" value="<?= lang('Login.login') ?>">
            </div>
        </div>

    </form>

</div>