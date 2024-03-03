<?php
use App\Models\ModelNarrator;
use App\Models\ModelPoint;

$modelNarrator = model(ModelNarrator::class);
$modelPoint = model(ModelPoint::class);

if(empty($narrativesOfNarrator)) {
    $modelPoint->deletePointsFromNarrator($idNarrator);
    $modelNarrator->deleteNarrator($idNarrator);
}

header('location:' . base_url('/narrative/list'));
exit;
?>