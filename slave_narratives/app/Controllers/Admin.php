<?php

namespace App\Controllers;

use App\Models\ModelAdmin;
use App\Models\ModelToken;
use App\Models\ModelVisitor;
use CodeIgniter\Controller;

class Admin extends Controller {

    public function login() {
        return view('other/header') .
               view('admin/login') .
               '<script>' .
               view('admin/script.js') .
               '</script>' .
               view('other/footer');
    }

    public function logout() {
        $model = model(ModelToken::class);

        if (isset($_COOKIE['token']))
            $model->deleteToken($_COOKIE['token']);

        return view('admin/logout');
    }

    public function admin() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        $model = model(ModelVisitor::class);

        $data = [
            'stats_daily' => $model->getVisits(),
            'monthly_data' => $model->getMonthlyData(),
            'narratives_stats' => $model->getVisitsNarratives()
        ];

        return view('other/header') .
               view('admin/admin', $data) .
               '<script>' .
               view('admin/script.js') .
               '</script>' .
               view('other/footer');
    }

    public function forgotPassword() {
        return view('other/header') .
               view('admin/forgotPassword') .
               '<script>' .
               view('admin/script.js') .
               '</script>' .
               view('other/footer');
    }

    public function create() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        return view('other/header') .
               view('admin/create') .
               '<script>' .
               view('admin/script.js') .
               '</script>' .
               view('other/footer');
    }

    public function editMail() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        return view('other/header') .
               view('admin/editMail') .
               '<script>' .
               view('admin/script.js') .
               '</script>' .
               view('other/footer');
    }

    public function editPassword() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        return view('other/header') .
               view('admin/editPassword') .
               '<script>' .
               view('admin/script.js') .
               '</script>' .
               view('other/footer');
    }

    public function delete() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        return view('other/header') .
               view('admin/delete') .
               '<script>' .
               view('admin/script.js') .
               '</script>' .
               view('other/footer');
    }

    public function token() {
        $model = model(ModelAdmin::class);

        if (!empty($_GET['token']))
            $token = $_GET['token'];

        $data['email'] = $model->getMailFromToken($token);

        return view('other/header') .
               view('admin/token', $data) .
               '<script>' .
               view('admin/script.js') .
               '</script>' .
               view('other/footer');
    }

    public function traitLogin() {
        $modelAdmin = model(ModelAdmin::class);
        $modelToken = model(ModelToken::class);

        $mail = $_POST['mail'] ?? '';

        $data['admin'] = $modelAdmin->getAdminFromMail($mail);

        if ($data['admin'] !== null && isset($_POST['rememberme'])
            && isset($_POST['password']) && password_verify(htmlentities($_POST['password']), $data['admin']['password'])) {
            // get rid of expired tokens
            $modelToken->removeInvalidTokens();
            $data['token'] = $modelToken->createToken($data['admin']['id']);
        }

        return view('other/header') .
               view('admin/traitLogin', $data);
    }

    public function traitForgotPassword() {
        $model = model(ModelAdmin::class);

        $mail = $_POST['mail'] ?? '';

        $data['admin'] = $model->getAdminFromMail($mail);

        return view('admin/traitForgotPassword', $data);
    }

    public function traitTokenPassword() {
        return view('other/header') .
               view('admin/traitTokenPassword');
    }

    public function traitCreate() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        return view('other/header') .
               view('admin/traitCreate');
    }

    public function traitEditMail() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        return view('other/header') .
               view('admin/traitEditMail');
    }

    public function traitEditPassword() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        return view('other/header') .
               view('admin/traitEditPassword');
    }

    public function traitDelete() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        return view('other/header') .
               view('admin/traitDelete');
    }

    public function stats() {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        $modelVisits = model(ModelVisitor::class);

        $data['monthly_data'] = $modelVisits->getMonthlyData();

        return view('other/header') .
               view('admin/stats', $data).
               view('other/footer');
    }

    public function traitTokenCookie() {
        $model = model(ModelToken::class);

        if (!isset($_SESSION['idAdmin']) && isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        } else {
            $token = '';
        }

        $data['token'] = $model->isTokenValid($token);

        return view('admin/traitTokenCookie', $data);
    }

}
