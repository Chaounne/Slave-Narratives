<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class Lang extends Controller {

    public function change_lang() {
        $supportedLangs = config('App')->supportedLocales;
        if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $supportedLangs))
            $currentLang = $_COOKIE['lang'];
        else
            $currentLang = Services::language()->getLocale();
        setcookie('lang', $supportedLangs[(array_search($currentLang, $supportedLangs)+1)%sizeof($supportedLangs)], time() + 3600 * 24 * 30);

        session_start();
        $redirect_url = $_SESSION['_ci_previous_url'] ?? base_url();

        header('location: ' . $redirect_url);
        exit;
    }

}