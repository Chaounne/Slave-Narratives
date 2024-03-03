<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelIndigenousArea extends Model {

    protected $table = 'indigenous_area';
    protected $allowedFields = ['id','id_style','geoj'];

    public function getIndigenousAreas() {
        return $this->asArray()
                    ->findAll(40);
    }

}