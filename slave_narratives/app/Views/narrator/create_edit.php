<?php
use App\Models\ModelNarrator;
use App\Models\ModelPoint;

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $birth = $_POST['birth'];
    $death = $_POST['death'];
    $freeing_ways_en = $_POST['freeing_ways_en'];
    $freeing_ways_fr = $_POST['freeing_ways_fr'];
    $parents_origin_en = $_POST['parents_origin_en'];
    $parents_origin_fr = $_POST['parents_origin_fr'];
    $abolitionist_en = $_POST['abolitionist_en'];
    $abolitionist_fr = $_POST['abolitionist_fr'];
    $peculiarities_en = $_POST['peculiarities_en'];
    $peculiarities_fr = $_POST['peculiarities_fr'];
    $has_wrote_several_narratives = $_POST['has_wrote_several_narratives'];

    $points = $points ?? [[]];
    $nextPoint = 0;
    // only one point for each of these 2 types are allowed
    $tabOfUniquePoints = ["birth" => false, "death" => false];

    while (!empty($_POST['point_'.$nextPoint.'_type'])) {
        foreach ($tabOfUniquePoints as $key => $value) {
            if ($_POST['point_' . $nextPoint . '_type'] == $key) {
                if ($tabOfUniquePoints[$key]) {
                    $dontAdd = true;
                    break;
                }
                else $tabOfUniquePoints[$key] = true;
            }
            $dontAdd = false;
        }
        if (!$dontAdd) {
            $points[$nextPoint]['type'] = $_POST['point_' . $nextPoint . '_type'];
            $points[$nextPoint]['longitude'] = preg_match('/^-?[0-9]{1,20}$/', str_replace(".", "", $_POST['point_' . $nextPoint . '_lon'])) ? str_replace(",", ".", $_POST['point_' . $nextPoint . '_lon']) : '' & $error = lang('Narrative.err_lon_lat');
            $points[$nextPoint]['latitude'] = preg_match('/^-?[0-9]{1,20}$/', str_replace(".", "", $_POST['point_' . $nextPoint . '_lat'])) ? str_replace(",", ".", $_POST['point_' . $nextPoint . '_lat']) : '' & $error = lang('Narrative.err_lon_lat');
            $points[$nextPoint]['place_en'] = $_POST['point_' . $nextPoint . '_place_en'];
            $points[$nextPoint]['place_fr'] = $_POST['point_' . $nextPoint . '_place_fr'];
        }
        $nextPoint += 1;
    }

    if (empty($error)) {
        $modelPts = model(ModelPoint::class);
        $modelNarrator = model(ModelNarrator::class);
        $id_narrator = $modelNarrator->addOrUpdate($name, $birth, $death, $freeing_ways_en, $freeing_ways_fr, 
        $parents_origin_en, $parents_origin_fr, $abolitionist_en, $abolitionist_fr, $peculiarities_en, $peculiarities_fr,
        $has_wrote_several_narratives, $narrator['id'] ?? 0);

        foreach($points as $p) {
            if (!empty($p))
                $modelPts->addOrUpdate($p['longitude'], $p['latitude'],
                    $p['place_en'], $p['place_fr'], $p['type'], null, $narrator['id'] ?? $id_narrator,
                    $p['id'] ?? 0);
        }

        header('location: ' . site_url() . 'narrative/list');
        exit;
        
    } else
        unset($narrator);
}
?>

<body>
    <div class="form">
        <form method="POST">

            <?php
            if (isset($narrator))
                echo '<h3>' . lang('Narrator.edit') . '</h3>';
            else
                echo '<h3>' . lang('Narrator.create_narrator') . '</h3>';
            
            if (!empty($error))
                echo nl2br('<h5 style="color: #dc3545;">' . $error . '</h5>');
            ?>

            <label><?= lang('Narrator.name') ?></label>
            <input type="text" id="name" name="name" placeholder="<?= lang('Narrator.name') ?>" maxlength="64" value="<?= $narrator['name'] ?? $name ?? '' ?>" required>

            <label><?= lang('Narrator.birth_year') ?></label>
            <input type="text" id="birth" name="birth" placeholder="<?= lang('Narrator.birth_year') ?>" maxlength="32" value="<?= $narrator['birth'] ?? $birth ?? '' ?>" required>

            <label><?= lang('Narrator.death_year') ?></label>
            <input type="text" id="death" name="death" placeholder="<?= lang('Narrator.death_year') ?>" maxlength="32" value="<?= $narrator['death'] ?? $death ?? '' ?>" required>

            <label><?= lang('Narrator.freeing_ways') . ' EN' ?></label>
            <input type="text" id="freeing_ways_en" name="freeing_ways_en" placeholder="<?= lang('Narrator.freeing_ways')  . ' EN'?>" maxlength="128" value="<?= $narrator['freeing_ways_en'] ?? $freeing_ways_en ?? '' ?>" required>

            <label><?= lang('Narrator.freeing_ways') . ' FR' ?></label>
            <input type="text" id="freeing_ways_fr" name="freeing_ways_fr" placeholder="<?= lang('Narrator.freeing_ways')  . ' FR'?>" maxlength="128" value="<?= $narrator['freeing_ways_fr'] ?? $freeing_ways_fr ?? '' ?>" required>

            <label><?= lang('Narrator.parents_origin')  . ' EN'?></label>
            <input type="text" id="parents_origin_en" name="parents_origin_en" placeholder="<?= lang('Narrator.parents_origin') . ' EN' ?>" maxlength="256" value="<?= $narrator['parents_origin_en'] ?? $parents_origin_en ?? '' ?>" required>

            <label><?= lang('Narrator.parents_origin')  . ' FR'?></label>
            <input type="text" id="parents_origin_fr" name="parents_origin_fr" placeholder="<?= lang('Narrator.parents_origin')  . ' FR'?>" maxlength="256" value="<?= $narrator['parents_origin_fr'] ?? $parents_origin_fr ?? '' ?>" required>

            <label><?= lang('Narrator.abolitionist')  . ' EN'?></label>
            <input type="text" id="abolitionist_en" name="abolitionist_en" placeholder="<?= lang('Narrator.abolitionist') . ' EN' ?>" maxlength="64" value="<?= $narrator['abolitionist_en'] ?? $abolitionist_en ?? '' ?>" required>

            <label><?= lang('Narrator.abolitionist')  . ' FR'?></label>
            <input type="text" id="abolitionist_fr" name="abolitionist_fr" placeholder="<?= lang('Narrator.abolitionist') . ' FR' ?>" maxlength="64" value="<?= $narrator['abolitionist_fr'] ?? $abolitionist_fr ?? '' ?>" required>

            <label><?= lang('Narrator.peculiarities')  . ' EN'?></label>
            <input type="text" id="peculiarities_en" name="peculiarities_en" placeholder="<?= lang('Narrator.peculiarities') . ' EN' ?>" maxlength="128" value="<?= $narrator['peculiarities_en'] ?? $peculiarities_en ?? '' ?>">

            <label><?= lang('Narrator.peculiarities')  . ' FR'?></label>
            <input type="text" id="peculiarities_fr" name="peculiarities_fr" placeholder="<?= lang('Narrator.peculiarities') . ' FR'?>" maxlength="128" value="<?= $narrator['peculiarities_fr'] ?? $peculiarities_fr ?? '' ?>">

            <label><?= lang('Narrator.has_wrote_several_narratives') ?></label>
                <div class="flex-row flex-row-radio">
                    <div class="radio-div"> <!-- yes -->
                        <input type="radio" class="radio-narratives" id="has_wrote_several_narratives_yes" name="has_wrote_several_narratives" value="1" <?php if (isset($narrator['has_wrote_several_narratives']) && $narrator['has_wrote_several_narratives'] == "1") echo 'checked'; else if (isset($has_wrote_several_narratives) && $has_wrote_several_narratives == "1") echo 'checked' ?> required>
                        <label class="label-narratives" for="has_wrote_several_narratives_yes"><?= lang('Narrator.yes') ?></label>
                    </div>
                    <div class="radio-div"> <!-- no-->
                    <input type="radio" class="radio-narratives" id="has_wrote_several_narratives_no" name="has_wrote_several_narratives" value="0" <?php if (isset($narrator['has_wrote_several_narratives']) && $narrator['has_wrote_several_narratives'] == "0") echo 'checked'; else if (isset($has_wrote_several_narratives) && $has_wrote_several_narratives == "0") echo 'checked' ?> required>
                        <label class="label-narratives" for="has_wrote_several_narratives_no"><?= lang('Narrator.no') ?></label>
                    </div>
                </div>

           <!-- POINTS -->
            <h3><?= lang('Narrator.points_title') ?></h3>

            <div class="flex-row" id="addNewPoints">
                <a id="add_point" class="button-brown" onclick="createNewPoint()"><?= lang('Narrator.add_point') ?></a>
            </div>

            <?php
            if (isset($points)) {
                foreach($points as $p) { ?>
                    <script>
                        createNewPoint(<?= json_encode($p) ?>);
                    </script>
            <?php } } ?>
            <!-- END POINTS -->

            <input class="submit" id="submit" type="submit" name="submit" value="<?= lang('Narrator.submit') ?>">
        </form>
    </div>

    <div id="buttoncontainer">
        <?php
            if (!isset($narrator)) { ?>
            <a href="<?= site_url() . "narrative/list" ?>" class="button-brown"> <?= lang('Narrative.back_to_narratives_census') ?></a>
        <?php } else { ?>
            <a href="<?= site_url() . "narrator/list" ?>" class="button-brown"> <?= lang('Narrative.back_to_narrators_census') ?></a>
        <?php } ?>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
