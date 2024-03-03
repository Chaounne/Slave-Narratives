<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class ModelPoint extends Model {

    protected $table = 'point';
    protected $allowedFields = ['id', 'type', 'id_narrative', 'id_narrator', 'link', 'place_en', 'place_fr', 'latitude', 'longitude'];
    protected $langFields = [];

    public function __construct()
    {
        parent::__construct();

        $supportedLangs = config('App')->supportedLocales;
        if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $supportedLangs)) {
            $lang = $_COOKIE['lang'];
        } else {
            $lang = Services::language()->getLocale();
        }

        $this->langFields[0] = 'place_' . $lang . ' as place';
    }

    public function getPointsOfNarrativeWithNarratorAndNarrative($narrativeId) {
        $nariId = $this->db->escapeLikeString($narrativeId);

        $modelNI = model(ModelNarrative::class);
        $naroId = $modelNI->getNarratorIdFromNarrativeId($nariId);

        return $this->asArray()
                    ->join('narrative', 'narrative.id = '.$nariId)
                    ->join('narrator', 'narrative.id_narrator = narrator.id')
                    ->select('narrative.id as id_narrative, point.id as id_point, narrative.type as type_narrative, point.type as type_point,
                            narrator.id as id_narrator, name, link, title_beginning, publication_date, latitude, longitude,'.$this->langFields[0])
                    ->Where(['point.id_narrator' => $naroId])
                    ->orWhere(['point.id_narrative' => $nariId])
                    ->findAll();
    }

    public function getPublicationPointOfNarrative($narrativeId) {
        return $this->Where(['id_narrative' => $narrativeId, 'type' => "publication"])
                    ->first();
    }

    public function getPointsOfNarrator($narratorId) {
        return $this->asArray()
                    ->Where(['id_narrator' => $narratorId])
                    ->orderBy('id')
                    ->findAll();
    }

    public function getPointsOfType($pointType) {
        if ($pointType != "publication") {
            return $this->join('narrator', 'narrator.id = point.id_narrator')
                        ->join('narrative', 'narrative.id_narrator = narrator.id')
                        ->select('narrative.id as id_narrative, point.id as id_point, narrative.type as type_narrative, point.type as type_point,
                                narrator.id as id_narrator, name, link, title_beginning, publication_date, latitude, longitude,' . $this->langFields[0])
                        ->like(['point.type' => $this->db->escapeLikeString($pointType)])
                        ->findAll();
        } else {
            return $this->join('narrative', 'point.id_narrative = narrative.id')
                        ->join('narrator', 'narrator.id = narrative.id_narrator')
                        ->select('narrative.id as id_narrative, point.id as id_point, narrative.type as type_narrative, point.type as type_point,
                                narrator.id as id_narrator, name, link, title_beginning, publication_date, latitude, longitude,' . $this->langFields[0])
                        ->like(['point.type' => $this->db->escapeLikeString($pointType)])
                        ->findAll();
        }
    }

    public function addOrUpdate($lon, $lat, $place_en, $place_fr, $type, $narrativeId = null, $narratorId = null, $pointId = 0) {
        $data = [
            'longitude' => $lon,
            'latitude' => $lat,
            'place_en' => $place_en,
            'place_fr' => $place_fr,
            'type' => $type,
            'id_narrative' =>  $narrativeId,
            'id_narrator' =>  $narratorId
        ];

        if ($pointId != 0)
            return $this->where('id', $this->db->escapeLikeString($pointId))->set($data)->update();
        else
            return $this->insert($data);
    }

    public function deletePointFromNarrative($narrativeId) {
        $this->where(['id_narrative' => $this->db->escapeLikeString($narrativeId)])->delete();
    }

    public function deletePointsFromNarrator($narratorId) {
        $this->where(['id_narrator' => $this->db->escapeLikeString($narratorId)])->delete();
    }

    public function deletePoint($pointId) {
        $this->where(['id' => $this->db->escapeLikeString($pointId)])->delete();
    }

}