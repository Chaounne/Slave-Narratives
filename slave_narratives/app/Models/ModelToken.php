<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelToken extends Model {

    protected $table = 'token';
    protected $allowedFields = ['token', 'id_admin', 'valid_until'];

    public function isTokenValid($token) {
        return $this->where(['TOKEN' => htmlentities($token)])
                    ->where('valid_until >=', date(DATE_ATOM))
                    ->first();
    }

    public function removeInvalidTokens() {
        return $this->where('valid_until <', date(DATE_ATOM))->delete();
    }

    public function createToken($adminId) {
        $oldToken = '';

        while ($oldToken !== null) {
            $uniqId = uniqid();
            $time = time();

            $tokenData = "{$adminId}#{$uniqId}#{$time}";
            $newToken = hash('sha512', $tokenData);

            $oldToken = $this->isTokenValid($newToken);
        }

        $this->insert(['token' => $newToken, 'id_admin' => $adminId, 'valid_until' => date(DATE_ATOM, time() + 3600 * 24 * 30)]);

        return $newToken;
    }

    public function deleteToken($token) {
        $this->where(['token' => htmlentities($token)])->delete();
    }

    public function deleteTokenFromAdmin($adminId) {
        $this->where(['id_admin' => htmlentities($adminId)])->delete();
    }

}