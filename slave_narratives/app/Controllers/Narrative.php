<?php

namespace App\Controllers;
 
use App\Models\ModelAdmin;
use App\Models\ModelCountry;
use App\Models\ModelCustomLocation;
use App\Models\ModelNarrative;
use App\Models\ModelNarrator;
use App\Models\ModelPoint;
use App\Models\ModelUSBorder;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Narrative extends Controller {

    public function list() {
        $model = model(ModelNarrative::class);
        $data['narratives'] = $model->getNarrativesWithNarrator();

        return view ('other/header') .
               '<script>' .
               view('narrative/script.js') .
               '</script>' .
               view ('narrative/list', $data) .
               view ('other/footer');
    }

    public function narrative($narrativeId) {
        $modelNarrative = model(ModelNarrative::class);
        $modelNarrator = model(ModelNarrator::class);

        $data['narrative'] = $modelNarrative->getNarrativeFromId($narrativeId);

		if (empty($data['narrative'])) {
            throw new PageNotFoundException('Couldn\'t find the narrative.');
        }

        $data['narrator'] = $modelNarrator->getNarratorFromId($data['narrative']['id_narrator']);

        return view('other/header') .
               '<script>' .
               view('narrative/script.js') .
               '</script>' .
               view('narrative/narrative', $data) .
               view('other/footer');
    }

    public function deleteAllFromNarrative($idNarrative, $idNarrator) {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        $modelNarrative = model(ModelNarrative::class);
        $modelUSBorder = model(ModelUSBorder::class);
        $modelPoint = model(ModelPoint::class);
        $modelCustomLocation = model(ModelCustomLocation::class);

        $modelUSBorder->deleteUsBorder($idNarrative);
        $modelPoint->deletePointFromNarrative($idNarrative);
        $modelCustomLocation->deleteCustomLocation($idNarrative);
        $modelNarrative->deleteNarrative($idNarrative);

        $data = [
            'narrativesOfNarrator' => $modelNarrative->getNarrativesFromNarrator($idNarrator),
            'idNarrator' => $idNarrator
        ];

        return view('other/header') .
               view('narrative/delete', $data) .
               view('other/footer');
    }

    // create or edit a narrative
    public function createOrEdit($narrativeId = null) {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        $modelNarrator = model(ModelNarrator::class);
        $modelCountry = model(ModelCountry::class);
        $modelPoint = model(ModelPoint::class);

        $data = [
            'narrators' => $modelNarrator->getNarrators(),
            'countries' => $modelCountry->getCountries()
        ];

        if ($narrativeId != null) {
            $modelNarrative = model(ModelNarrative::class);
            $data += [
                'narrative' => $modelNarrative->getNarrativeFromId($narrativeId, false),
                'pubPoint' => $modelPoint->getPublicationPointOfNarrative($narrativeId)
            ];
            if ($data['narrative'] == null) {
                header('location: ' . site_url() . 'narrative/list');
                exit;
            }
        }

        return view('other/header') .
            view('narrative/create_edit', $data) .
            view('other/footer');
    }

}