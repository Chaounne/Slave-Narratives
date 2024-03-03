<?php
    // Récupérer le message d'erreur s'il existe
    $erreur_contact = isset($_SESSION['erreur-contact']) ? $_SESSION['erreur-contact'] : '';
    // Récupérer le message de fin s'il existe
    $msg_contact = isset($_SESSION['msg-contact']) ? $_SESSION['msg-contact'] : '';
    // Effacement des variables de session
    unset($_SESSION['erreur-contact']);
    unset($_SESSION['msg-contact']);

    if (!empty($erreur_contact)) {
        echo('<p class="error-message">'.$erreur_contact.'</p>');
    }
    if (!empty($msg_contact)) {
        echo('<p class="password-oublie-message">'.$msg_contact.'</p>');
    }

?>

<body>

    <div class="form">

        <form method="POST" action="<?= base_url('/traitContact'); ?>">

            <h3><?= lang('HeaderFooter.contact')?></h3>

            <?php  
            $first_name = '';
            $last_name = '';
            $email = '';
            $subject = '';
            $message = '';

            if (isset($_SESSION['contact_values'])) {

                $contactValues = $_SESSION['contact_values'];

                // Récupérer les valeurs de la session
                $first_name = isset($contactValues['first_name']) ? $contactValues['first_name'] : '';
                $last_name = isset($contactValues['last_name']) ? $contactValues['last_name'] : '';
                $email = isset($contactValues['email']) ? $contactValues['email'] : '';
                $subject = isset($contactValues['subject']) ? $contactValues['subject'] : '';
                $message = isset($contactValues['message']) ? $contactValues['message'] : '';

                ?>

                <label for="first_name"><?= lang('Contact.first_name') ?></label>
                <input type="text" class="contact-inputs" name="first_name" placeholder="<?= lang('Contact.first_name') ?>" required minlength="2" value="<?= $first_name ?>"/>

                <label for="last_name"><?= lang('Contact.last_name') ?></label>
                <input type="text" class="contact-inputs" name="last_name" placeholder="<?= lang('Contact.last_name') ?>" required minlength="2" value="<?= $last_name ?>"/>

                <label for="email"><?= lang('Contact.email') ?></label>
                <input type="email" class="contact-inputs" name="email" placeholder="<?= lang('Contact.email') ?>" required minlength="5" value="<?= $email ?>"/>

                <label for="subject"><?= lang('Contact.subject') ?></label>
                <input type="text" class="contact-inputs" name="subject" placeholder="<?= lang('Contact.subject') ?>" required minlength="2" value="<?= $subject ?>"/>

                <label for="message"><?= lang('Contact.message') ?></label>
                <textarea class="last-champ-contact" name="message" placeholder="<?= lang('Contact.message') ?>" required maxlength="65535"><?= $message ?></textarea>

                <input id="button-contact" type="submit" name="envoyer" value="<?= lang('Contact.send') ?>"></div>

            <?php

            } else {

            ?>

                <label for="first_name"><?= lang('Contact.first_name') ?></label>
                <input type="text" class="contact-inputs" name="first_name" placeholder="<?= lang('Contact.first_name') ?>" required minlength="2"/>

                <label for="last_name"><?= lang('Contact.last_name') ?></label>
                <input type="text" class="contact-inputs" name="last_name" placeholder="<?= lang('Contact.last_name') ?>" required minlength="2"/>

                <label for="email"><?= lang('Contact.email') ?></label>
                <input type="email" class="contact-inputs" placeholder="<?= lang('Contact.email') ?>" name="email" required minlength="5"/>

                <label for="subject"><?= lang('Contact.subject') ?></label>
                <input type="text" class="contact-inputs" placeholder="<?= lang('Contact.subject') ?>" name="subject" required minlength="2"/>

                <label for="message"><?= lang('Contact.message') ?></label>
                <textarea class="last-champ-contact" placeholder="<?= lang('Contact.message') ?>" name="message" required maxlength="65535"></textarea>

                <input id="button-contact" type="submit" name="envoyer" value="<?= lang('Contact.send') ?>"></div>

            <?php 

            }

            ?>

        </form>

    </div>

</body>