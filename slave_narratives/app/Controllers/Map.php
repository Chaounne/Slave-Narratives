<?php
  
namespace App\Controllers;

use App\Models\ModelAfricanKingdom;
use App\Models\ModelCustomLocation;
use App\Models\ModelIndigenousArea;
use App\Models\ModelNarrative;
use App\Models\ModelPoint;
use App\Models\ModelUSBorder;
use CodeIgniter\Controller;

class Map extends Controller {

    public function index() {
        $modelUB = model(ModelUSBorder::class);
        $modelAK = model(ModelAfricanKingdom::class);
        $modelIA = model(ModelIndigenousArea::class);
        $modelP = model(ModelPoint::class);
        $modelCL = model(ModelCustomLocation::class);
        $modelNI = model(ModelNarrative::class);

        helper('form');

        // if searching by narrative
        if (isset($_GET['narrative'])) {
            $data = [
                'narrativeId' => $_GET['narrative']
            ];

            $data = [
                'narrativeId' => $data['narrativeId'],
                'nar_points' => $modelNI->getNarrativesWithNarrator(),
                'us_border' => $modelUB->getUsBorderOfNarrative($data['narrativeId']),
                'indigenous_areas' => $modelIA->getIndigenousAreas(),
                'african_kingdoms' => $modelAK->getAfricanKingdoms(),
                'points' => $modelP->getPointsOfNarrativeWithNarratorAndNarrative($data['narrativeId']),
                'custom_locations' => $modelCL->searchCustomLocation($data['narrativeId'])
            ];

            return view('other/header') .
                   '<script>' .
                   view('map/style.js') .
                   '</script>' .
                   '<div class="map-sidebar">' .
                   view('map/narrative', $data) .
                   view('map/sidebar', $data) .
                   '</div>' .
                   view('other/footer');
        }

        // if searching by place / if not searching
        else {
            $data = [
                'place' => $_GET['place'] ?? 'publication'
            ];

            $data = [
                'place' => $data['place'],
                'nar_points' => $modelNI->getNarrativesWithNarrator(),
                'nar_place' => $modelP->getPointsOfType($data['place']),
                'indigenous_areas' => $modelIA->getIndigenousAreas(),
                'african_kingdoms' => $modelAK->getAfricanKingdoms()
            ];

            return view('other/header') .
                   '<script>' .
                   view('map/style.js') .
                   '</script>' .
                   '<div class="map-sidebar">' .
                   view('map/places', $data) .
                   view('map/sidebar', $data) .
                   '</div>' .
                   view('other/footer');
        }
    }
}