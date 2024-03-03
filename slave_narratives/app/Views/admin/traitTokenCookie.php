<?php

if ($token != null) {
    session_start();
    $_SESSION['idAdmin'] = $token['id_admin'];
    // reset expiration time
    setcookie('token', $token['token'], time() + 3600 * 24 * 30, '/');
} else {
    // the token is not valid/has expired so we delete it
    setcookie('token', '', 0, '/');
}

header('location:' . ($_SESSION['_ci_previous_url'] ?? base_url()));
exit;
