<?php

	if (isset($_POST['password'])) {

        $password = htmlentities($_POST['password']);

        //tout bon
        if ($admin != null && password_verify($password, $admin['password'])) {
            $_SESSION['idAdmin'] = $admin['id'];
            if (isset($token))
                setcookie('token', $token, time() + 3600 * 24 * 30, '/');
            header('location:' . base_url('/admin'));
            exit;
        }

        //login pas dans la BD
        else if ($admin == null) {
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.no_account');
        }

        //mauvais password
        else {
            $_SESSION['error_message'] = lang('TraitCRUDAdmin.wrong_password');
        }
    }

    header('location:' . base_url('/admin/login'));
    exit;
