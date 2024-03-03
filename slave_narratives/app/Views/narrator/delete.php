<?php
use App\Models\ModelNarrator;
use App\Models\ModelNarrative;
use App\Models\ModelUSBorder;
use App\Models\ModelPoint;
use App\Models\ModelCustomLocation;

$modelUSBorder = model(ModelUSBorder::class);
$modelPoint = model(ModelPoint::class);
$modelCustomLocation = model(ModelCustomLocation::class);
$modelNarrative = model(ModelNarrative::class);
$modelNarrator = model(ModelNarrator::class);

if(!empty($narrativesOfNarrator)) { //narrator's all narratives
    foreach ($narrativesOfNarrator as $n):
        $modelUSBorder->deleteUsBorder($n['id']);
        $modelPoint->deletePointFromNarrative($n['id']);
        $modelCustomLocation->deleteCustomLocation($n['id']);
        $modelNarrative->deleteNarrative($n['id']);
    endforeach;
}

$modelPoint->deletePointsFromNarrator($idNarrator);
$modelNarrator->deleteNarrator($idNarrator);

header('location:' . base_url('/narrative/list'));
exit;
?>