<?php
    session_start();

    if (isset($_SESSION['idAdmin'])) {
        session_destroy();
        setcookie('token', '', 0, '/');
    }

    header('location:' . ($_SESSION['_ci_previous_url'] ?? base_url()));
    exit;
