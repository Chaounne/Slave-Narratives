<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAfricanKingdom extends Model {

    protected $table = 'african_kingdom';
    protected $allowedFields = ['id', 'name', 'geoj'];

    public function getAfricanKingdoms() {
        return $this->asArray()
                    ->findAll(20);
    }

}