<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Contact extends Controller {

    public function contact() {
        return view('other/header') .
               view('contact/contact') .
               view('other/footer');
    }

    public function traitContact() {
        return view('other/header') .
               view('contact/traitContact');
    }

}