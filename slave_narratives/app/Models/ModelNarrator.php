<?php

namespace App\Models;

use Config\Services;
use CodeIgniter\Model;

class ModelNarrator extends Model {

    protected $table = 'narrator';
    protected $allowedFields = ['name', 'birth', 'death', 'freeing_ways_en', 'freeing_ways_fr', 'parents_origin_en',
                                'parents_origin_fr', 'abolitionist_en', 'abolitionlist_fr', 'peculiarities_en',
                                'peculiarities_fr', 'has_wrote_several_narratives', 'id'];
    protected $standardFields = ['name', 'birth', 'death', 'has_wrote_several_narratives', 'id'];
    protected $langFields = ['freeing_ways', 'parents_origin', 'abolitionist', 'peculiarities'];

    public function __construct()
    {
        parent::__construct();

        $supportedLangs = config('App')->supportedLocales;
        if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $supportedLangs)) {
            $lang = $_COOKIE['lang'];
        } else {
            $lang = Services::language()->getLocale();
        }

        foreach ($this->langFields as $field) {
            $this->standardFields[] = $field . '_' . $lang . ' as ' . $field;
        }
    }

    public function getNarrators() {
        return $this->select($this->standardFields)
                    ->orderBy('name')
                    ->findAll();
    }

    public function getNarratorFromId($narratorId, $useAlias = true) {
        if ($useAlias) {
            return $this->select($this->standardFields)
                    ->where(['id' => htmlentities($narratorId)])
                    ->first();
        }

        return $this->where(['id' => htmlentities($narratorId)])
                    ->first();
    }     

    public function addOrUpdate($name, $birth, $death, $freeing_ways_en, $freeing_ways_fr, $parents_origin_en, $parents_origin_fr, $abolitionist_en, $abolitionist_fr, $peculiarities_en, $peculiarities_fr, $has_wrote_several_narratives, $narratorId = 0) {
        $data = [
            'name' => htmlentities($name),
            'birth' => htmlentities($birth),
            'death' => htmlentities($death),
            'freeing_ways_en' => htmlentities($freeing_ways_en),
            'freeing_ways_fr' => htmlentities($freeing_ways_fr),
            'parents_origin_en' => htmlentities($parents_origin_en),
            'parents_origin_fr' => htmlentities($parents_origin_fr),
            'abolitionist_en' => htmlentities($abolitionist_en),
            'abolitionist_fr' => htmlentities($abolitionist_fr),
            'peculiarities_en' => htmlentities($peculiarities_en),
            'peculiarities_fr' => htmlentities($peculiarities_fr),
            'has_wrote_several_narratives' => htmlentities($has_wrote_several_narratives)
        ];

        if ($narratorId != 0)
            return $this->where('id', $narratorId)->set($data)->update();
        else
            return $this->insert($data);
    }

    public function deleteNarrator($id) {
        return $this->where(['id' => htmlentities($id)])
                    ->delete();
    }

}