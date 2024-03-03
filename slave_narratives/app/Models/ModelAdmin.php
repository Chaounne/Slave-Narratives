<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAdmin extends Model {

    protected $table = 'admin';
    protected $allowedFields = ['id', 'email', 'password', 'password_recovery_token'];

    /*Getters*/

    public function getAdmins() {
        return $this->findAll();
    }

    public function getAdminFromId($id) {
        return $this->where(['id' => htmlentities($id)])
                    ->first();
    }

    public function getAdminFromMail($mail) {
        return $this->where(['email' => htmlentities($mail)])
                    ->first();
    }

    public function getMailFromToken($token) {
        $admin = $this->where('password_recovery_token', $token)
                      ->first();

        if ($admin != null) {
            return $admin['email'];
        } else {
            return null;
        }
    }

    /*CRUD Admin*/

    public function createAdmin($mail, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->insert(['email' => htmlentities($mail), 'password' => $hashedPassword]);
    }

    public function updatePassword($newPassword, $id) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        return $this->set(['password' => $hashedPassword])
                    ->where(['id' => htmlentities($id)])
                    ->update();
    }

    public function updateMail($newMail, $id) {
        return $this->set(['email' => htmlentities($newMail)])
                    ->where(['id' => htmlentities($id)])
                    ->update();
    }

    public function deleteAdmin($id) {
        $modelToken = model(ModelToken::class);
        $modelToken->deleteTokenFromAdmin($id);
        return $this->where(['id' => htmlentities($id)])
                    ->delete();
    }

    /*Autres fonctions*/

    public function checkValid() {
        session_start();

        if (isset($_SESSION['idAdmin'])) {
            $admin = $this->where(['id' => $_SESSION['idAdmin']])
                          ->first();

            if ($admin == null) {
                unset($_SESSION['idAdmin']);
                session_destroy();
                setcookie('token', '', 0, '/');
            }
        }

        if (!isset($_SESSION['idAdmin'])) {
            header('location: ' . base_url('admin/login'));
            exit();
        }

        session_write_close();
    }

    public function updatePasswordByMail($mail, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
        return $this->set(['password' => $hashedPassword, 'password_recovery_token' => null])
                    ->where(['email' => htmlentities($mail)])
                    ->update();
    }

    public function setToken($token, $mail) {
        return $this->set('password_recovery_token', $token)
                    ->where(['email' => htmlentities($mail)])
                    ->update();
    }

}