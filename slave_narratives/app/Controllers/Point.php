<?php

namespace App\Controllers;

use App\Models\ModelAdmin;
use App\Models\ModelPoint;
use CodeIgniter\Controller;

class Point extends Controller {

    public function deletePoint($pointId) {
        $modelAdmin = model(ModelAdmin::class);
        $modelAdmin->checkValid();

        $modelPoint = model(ModelPoint::class);
        $modelPoint->deletePoint($pointId);

        session_start();
        $redirect_url = $_SESSION['_ci_previous_url'] ?? base_url();
        header('location: ' . $redirect_url);
        exit;
    }

}