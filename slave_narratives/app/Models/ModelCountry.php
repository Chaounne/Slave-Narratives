<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCountry extends Model
{

    protected $table = 'country';
    protected $allowedFields = ['id','name','geoj'];

    public function getCountries(){
        $this->select('id, name');
        return $this->findAll();
    }

    public function getGeojOf($countryId) {
        $this->select('geoj, name')
            ->where('id', $countryId);
        $country = $this->first();
        return $country ? $country['geoj'] : null;
    }

}