<?php
    if (!empty($_SESSION)) {

        // Récupérer le message d'erreur s'il existe
        $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

        // Effacement des variables de session
        unset($_SESSION['error_message']);

        if (!empty($error_message)) {
            echo('<p class="error-message">'.$error_message.'</p>');
        }

    ?>

        <div class="form">
            <form method="POST" action="<?= base_url('/admin/traitEditMail'); ?>">

                <h3><?= lang('Admin.edit_email') ?></h3>

                <label for="email"><?= lang('CRUDAdmin.new_email') ?></label>
                <input type="email" class="contact-inputs" name="email" placeholder="<?= lang('CRUDAdmin.new_email') ?>" required minlength="5"/>

                <input id="button-contact" type="submit" name="modifier" value="<?= lang('CRUDAdmin.edit') ?>"></div>

            </form>
        </div>

    <?php
    }   
    ?>