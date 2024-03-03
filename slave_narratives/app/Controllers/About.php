<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class About extends Controller {

    public function about() {
        return view('other/header') .
               view('about/about') .
               view('other/footer');
    }

}