<?php
use App\Models\ModelAdmin;

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

            <form method="POST" action="<?= base_url('/admin/traitDelete'); ?>" onsubmit="return confirm('<?= lang('CRUDAdmin.confirm_delete') ?>');">

                <h3><?= lang('Admin.delete') ?></h3>

                <label for="selectAdmin"><?= lang('CRUDAdmin.email') ?></label>
                <select name="admins" id="selectAdmin" required>
                <option hidden value=""><?= lang('CRUDAdmin.select_admin') ?></option>


                    <?php

                        $modelAdmin = model(ModelAdmin::class);
                        $admin = $modelAdmin->getAdmins();


                        foreach($admin as $listOfAdmins) {
                            echo('<option value="'.$listOfAdmins['id'].'">'.$listOfAdmins['email'].'</option>');
                            var_dump($listOfAdmins['id']);
                        }

                    ?>

                </select>

                <input id="button-contact" type="submit" name="supprimer" value="<?= lang('CRUDAdmin.delete') ?>">

            </form>

        </div>

    <?php

    }   

    ?>