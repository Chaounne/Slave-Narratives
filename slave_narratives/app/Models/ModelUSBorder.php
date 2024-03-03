<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUSBorder extends Model {

    protected $table = 'us_border';
	protected $allowedFields = ['id', 'city', 'id_narrative', 'geoj', 'slave_name', 'label', 'category'];

    public function getUsBorderOfNarrative($narrativeId) {
		$idr = $this->db->escapeLikeString($narrativeId);

        return $this->asArray()
                    ->Where(['us_border.id_narrative' => $idr])
                    ->findAll();
	}

    public function deleteUsBorder($narrativeId) {
        $this->where(['id_narrative' => htmlentities($narrativeId)])->delete();
    }

}