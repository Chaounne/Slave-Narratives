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

            <form method="POST" action="<?= base_url('/admin/traitCreate'); ?>">

                <h3><?= lang('Admin.create') ?></h3>

                <label for="email"><?= lang('CRUDAdmin.email') ?></label>
                <input type="email" class="contact-inputs" name="email" placeholder="<?= lang('CRUDAdmin.email') ?>" required minlength="5"/>

                <p class="password-text"><?= lang('CRUDAdmin.password_conditions') ?></p>

                <label for="new-password"><?= lang('CRUDAdmin.new_password') ?></label>
                <input type="password" class="contact-inputs" name="new-password" placeholder="<?= lang('CRUDAdmin.new_password') ?>" required minlength="8"/>

                <label for="conf-password"><?= lang('CRUDAdmin.confirm_password') ?></label>
                <input type="password" class="contact-inputs" name="conf-password" placeholder="<?= lang('CRUDAdmin.confirm_password') ?>" required minlength="8"/>

                <input id="button-contact" type="submit" name="ajouter" value="<?= lang('CRUDAdmin.add') ?>"></div>

            </form>

        </div>

    <?php

    }   

    ?>