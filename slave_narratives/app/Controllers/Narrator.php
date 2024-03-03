<?php

namespace App\Controllers;

use App\Models\ModelAdmin;
use App\Models\ModelNarrative;
use App\Models\ModelNarrator;
use App\Models\ModelPoint;
use CodeIgniter\Controller;


class Narrator extends Controller {

    public function list() {
        $modelNarrator = model(ModelNarrator::class);
        $data['narrators'] = $modelNarrator->getNarrators();

        return view('other/header') .
                '<script>' .
               view('narrator/script.js') .
               '</script>' .
               view('narrator/list', $data) .
               view('other/footer');
    }
    public function createOrEdit($narratorId = null) {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        if ($narratorId != null) { //edit narrator
            $modelNarrator = model(ModelNarrator::class);
            $modelPoint = model(ModelPoint::class);
            $data = [
                'narrator' => $modelNarrator->getNarratorFromId($narratorId, false),
                'points' => $modelPoint->getPointsOfNarrator($narratorId)
            ];

            if ($data['narrator'] == null) {
                header('location: ' . site_url() . 'narrative/list');
                exit;
            }
        }

        return view('other/header') .
               '<script>' .
               view('narrator/script.js') .
               '</script>' .
               view('narrator/create_edit', $data ?? []) .
               view('other/footer');
    }

    public function delete($idNarrator) {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        $modelNarrative = model(ModelNarrative::class);
        $data = [
            'idNarrator' => $idNarrator,
            'narrativesOfNarrator' => $modelNarrative->getNarrativesFromNarrator($idNarrator)
        ];

        return view('other/header') .
               view('narrator/delete', $data) .
               view('other/footer');
    }

}