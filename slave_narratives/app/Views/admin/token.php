<?php

    if(isset($_SESSION['idAdmin']) || !isset($_SESSION['token'])) {
        header('location:' . base_url('/'));
        exit();

    }

    if($email != null) {

        $_SESSION['mail_token'] = $email;

        if (!empty($_SESSION['message_error_token']))  {
            echo('<p class="error-message">'.$_SESSION['message_error_token'].'</p>');
        }
        
?>

        <div class="form">

            <form method="post" action="<?= base_url('/admin/traitTokenPassword'); ?>">

                <h3><?= lang('CRUDAdmin.password_reset') ?></h3>
                    
                <p class="password-text"><?= lang('CRUDAdmin.password_conditions') ?></p>

                <label for="new-password-modif"><?= lang('CRUDAdmin.new_password') ?></label>
                <input type="password" class="subform-inputs" name="new-password-modif" placeholder="<?= lang('CRUDAdmin.new_password') ?>" required minlength="8"/>

                <label for="conf-password-modif"><?= lang('CRUDAdmin.confirm_password') ?></label>
                <input type="password" class="subform-inputs" name="conf-password-modif" placeholder="<?= lang('CRUDAdmin.confirm_password') ?>" required minlength="8"/>
                
                <input type="submit" id="button-admin" name="modifier" value="<?= lang('CRUDAdmin.edit') ?>">

            </form>

        </div>

        <?php

    }

?>