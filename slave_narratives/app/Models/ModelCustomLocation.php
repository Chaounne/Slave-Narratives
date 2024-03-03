<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelCustomLocation extends Model {

    protected $table = 'custom_location';
    protected $allowedFields = ['id_narrative', 'type', 'name', 'id', 'id_country'];

    public function searchCustomLocation($narrativeId) {
        $idr = $this->db->escapeLikeString($narrativeId);

        $results = $this->asArray()
            ->join('narrative nar', 'custom_location.id_narrative = nar.id')
            ->select('nar.id as id_nar, custom_location.id as id_cl, nar.type as type_nar,
        geoj, custom_location.type as type_cl, name, custom_location.id_country as id_country')
            ->Where(['custom_location.id_narrative' => $idr])
            ->findAll();

        foreach ($results as &$result) {
            if ($result['geoj'] === "") {
                $countryModel = model(ModelCountry::class);
                $geojOfCountry = $countryModel->getGeojOf($result['id_country']);

                $result['geoj'] = $geojOfCountry;
            }
        }

        return $results;
    }


    public function searchNameType($id_narrative) {
        $idr = $this->db->escapeLikeString($id_narrative);

        return $this->asArray()
            ->join('narrative nar', 'custom_location.id_narrative = nar.id')
            ->select('name, custom_location.type as type, custom_location.id as id')
            ->Where(['custom_location.id_narrative' => $idr])
            ->findAll();
    }

    public function addOrUpdate($id_narrative, $type, $name, $id_country, $id_loc = 0){

        $data = [
            'id_narrative' => $id_narrative,
            'type' => $type,
            'name' => $name,
            'id_country' => $id_country
        ];

        if($id_loc != 0 ){
            return $this->where('id', $id_loc)->set($data)->update();
        } else
            return $this->insert($data);
    }

    public function deleteCustomLocation($idrec) {
        $this->where(['id_narrative' => htmlentities($idrec)])->delete();
    }

}