<?php

namespace App\Models;

use Config\Services;
use CodeIgniter\Model;

class ModelNarrative extends Model {

    protected $table = 'narrative';
	protected $allowedFields = ['slave_name', 'title', 'publication_date', 'publication_mode_en', 'publication_mode_fr',
                                'type', 'historiography_en', 'historiography_fr', 'id_narrator', 'id', 'white_preface_en',
                                'white_preface_fr', 'preface_details_en', 'preface_details_fr', 'scribe_editor_en',
                                'scribe_editor_fr', 'link', 'title_beginning'];
    protected $standardFields = ['title', 'publication_date', 'type', 'id_narrator', 'id', 'link', 'title_beginning'];
    protected $langFields = ['publication_mode', 'historiography', 'white_preface', 'preface_details', 'scribe_editor'];

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

    public function getNarrativesWithNarrator() {
        return $this->asArray()
                    ->join('narrator', 'narrator.id = narrative.id_narrator')
                    ->select('narrative.id as id_narrative, narrator.id as id_narrator, title, name, publication_date')
                    ->orderBy('name')
                    ->findAll();
    }

    public function getNarratorIdFromNarrativeId($narrativeId) {
        return $this->select('id_narrator')
                    ->where(['id' => $this->db->escapeLikeString($narrativeId)])
                    ->first();
    }

    public function getNarrativeFromId($id, $useAlias = true) {
        if ($useAlias) {
            return $this->select($this->standardFields)
                        ->where(['id' => htmlentities($id)])
                        ->first();
        }

        return $this->where(['id' => htmlentities($id)])
                    ->first();
    }
    

    public function deleteNarrative($id) {
        $this->where(['id' => htmlentities($id)])->delete();
    }

    public function addOrUpdate($title, $shortTitle, $pubYear, $modPubEN, $modPubFR, $narType, $histographyEN, $histographyFR,
                                $idNarrator, $link, $scribeEN, $scribeFR, $whitePrefaceEN, $whitePrefaceFR, $prefaceDetailsEN, $prefaceDetailsFR, $narrativeId = 0) {
        $data = [
            'title' => $title,
            'title_beginning' => $shortTitle,
            'publication_date' => $pubYear,
            'publication_mode_en' => $modPubEN,
            'publication_mode_fr' => $modPubFR,
            'type' => $narType,
            'historiography_en' => $histographyEN,
            'historiography_fr' => $histographyFR,
            'id_narrator' => $idNarrator,
            'link' => $link,
            'scribe_editor_en' => $scribeEN,
            'scribe_editor_fr' => $scribeFR,
            'white_preface_en' => $whitePrefaceEN,
            'white_preface_fr' => $whitePrefaceFR,
            'preface_details_en' => $prefaceDetailsEN,
            'preface_details_fr' => $prefaceDetailsFR
        ];

        if ($narrativeId != 0)
            return $this->where('id', $this->db->escapeLikeString($narrativeId))->set($data)->update();
        else
            return $this->insert($data);
    }

    public function getNarrativesFromNarrator($narratorId) {
        return $this->where(['id_narrator' => $narratorId])->findAll(); //array of all narrative's narrator
    }

}