<?php

use App\Models\ModelCountry;
use App\Models\ModelCustomLocation;
use App\Models\ModelPoint;
use App\Models\ModelNarrative;

if (isset($_POST['submit'])) {
    $id_narrator = $_POST['id_narrator'];
    $title = $_POST['title'];
    $title_beginning = $_POST['title_beginning'];
    $publication_date = $_POST['publication_date'];
    $publication_mode_en = $_POST['publication_mode_en'];
    $publication_mode_fr = $_POST['publication_mode_fr'];
    $scribe_editor_en = $_POST['scribe_editor_en'] ?? '';
    $scribe_editor_fr = $_POST['scribe_editor_fr'] ?? '';
    $narrative_type = $_POST['narrative_type'];
    $historiography_en = $_POST['historiography_en'] ?? '';
    $historiography_fr = $_POST['historiography_fr'] ?? '';
    $white_preface_en = $_POST['white_preface_en'];
    $white_preface_fr = $_POST['white_preface_fr'];
    $preface_details_en = $_POST['preface_details_en'] ?? '';
    $preface_details_fr = $_POST['preface_details_fr'] ?? '';
    $link = $_POST['link'];
    $publication_point_lon = preg_match('/^-?[0-9]{1,20}$/', str_replace(".", "", $_POST['publication_point_lon'])) ? str_replace(",", ".", $_POST['publication_point_lon']) : '' & $error = lang('Narrative.err_lon_lat');
    $publication_point_lat = preg_match('/^-?[0-9]{1,20}$/', str_replace(".", "", $_POST['publication_point_lat'])) ? str_replace(",", ".", $_POST['publication_point_lat']) : '' & $error = lang('Narrative.err_lon_lat');;
    $publication_point_place_en = $_POST['publication_point_place_en'];
    $publication_point_place_fr = $_POST['publication_point_place_fr'];

    $countriesId = [[]];
    $countriesTypes = [[]];
    $country_name_to_bd = array();
    $nextCountry = 1;
    $nextType = 1;
    while(!empty($_POST['type_country'.$nextType])){
        $countriesTypes[$nextType] = $_POST['type_country'.$nextType];
        $nextType++;
    }

    if (empty($error)) {
        $modelNar = model(ModelNarrative::class);
        $modelPts = model(ModelPoint::class);
        $modelLoc = model(ModelCustomLocation::class);
        $modelCountry = model(ModelCountry::class);

        $country_list = $modelCountry->getCountries();

        $narrativeId = $modelNar->addOrUpdate($title, $title_beginning, $publication_date, $publication_mode_en, $publication_mode_fr,
            $narrative_type, $historiography_en, $historiography_fr, $id_narrator, $link, $scribe_editor_en, $scribe_editor_fr,
            $white_preface_en, $white_preface_fr, $preface_details_en, $preface_details_fr, $narrative['id'] ?? 0);

        $modelPts->addOrUpdate($publication_point_lon, $publication_point_lat, $publication_point_place_en, $publication_point_place_fr,
            "publication", $narrative['id'] ?? $narrativeId, null, $pubPoint['id'] ?? 0);

        while(!empty($_POST['id_country'.$nextCountry])){
            $countriesId[$nextCountry] = $_POST['id_country'.$nextCountry];
            foreach ($country_list as $c){
                if(strcmp($c['id'], $countriesId[$nextCountry]) == 0){
                    array_push($country_name_to_bd, $c['name']);
                }
            }
            $nextCountry++;
        }

        for ($i=1; $i<$nextCountry; $i++){
            if(empty($country_name_to_bd)){
                $modelLoc->addOrUpdate($nar['id'] ?? $narrativeId, $countriesTypes[$i], "vide", $countriesId[$i], $id_countries[$i] ?? 0);
            } else {
                $modelLoc->addOrUpdate($nar['id'] ?? $narrativeId, $countriesTypes[$i], $country_name_to_bd[$i-1], $countriesId[$i], $id_countries[$i] ?? 0);
            }
        }

        header('location: ' . site_url() . 'narrative/' . ($narrative['id'] ?? $narrativeId));
        exit;
    } else
        unset($narrative);
}

if(isset($narrative)){
    $modelLoc = model(ModelCustomLocation::class);

    $name_type_countries = $modelLoc->searchNameType($narrative['id']);
    $name_countries = array();
    $type_countries = array();
    $id_countries = array();

    foreach ($name_type_countries as $c){
        if($c['name'] != "NA" &&!empty($c['name'])){
            array_push($name_countries, $c['name']);
            array_push($type_countries, $c['type']);
        }
    }
}

?>
<body>
    <div class="form">
        <form method="POST">
            <?php
            if (isset($narrative['id']) || isset($narrativeId))
                echo '<h3>' . lang('Narrative.edit_narrative_title') . '</h3>';
            else
                echo '<h3>' . lang('Narrative.create_narrative') . '</h3>';

            if (!empty($error))
                echo nl2br('<h5 style="color: #dc3545;">' . $error . '</h5>');
            ?>

            <label><?= lang('Narrative.narrator') ?></label>
            <div class="flex-row">
                <a href="<?= site_url() . "narrator/create" ?>" class="button-brown"><?= lang('Narrator.create_narrator') ?></a>
                <select id="narrator" name="id_narrator" required>
                    <?php
                    if (!isset($narrative['id_narrator']))
                        echo '<option hidden value="">' . lang('Narrative.select_narrator') . '</option>';

                    foreach($narrators as $a) { ?>
                        <option value="<?= $a['id'] ?>" <?php
                            if (isset($narrative['id_narrator']) && $narrative['id_narrator'] == $a['id'])
                                echo 'selected';
                            else if (isset($id_narrator) && $id_narrator == $a['id'])
                                echo 'selected' ?>
                        ><?= $a['name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <label><?= lang('Narrative.nar_title') ?></label>
            <input type="text" id="title" name="title" placeholder="<?= lang('Narrative.nar_title') ?>" value="<?= esc($narrative['title'] ?? $title ?? '') ?>" required maxlength="512"/>

            <label><?= lang('Narrative.nar_title_beginning') ?></label>
            <input type="text" id="title_beginning" name="title_beginning" placeholder="<?= lang('Narrative.nar_title_beginning') ?>" value="<?= esc($narrative['title_beginning'] ?? $title_beginning ?? '') ?>" required maxlength="32"/>

            <label><?= lang('Narrative.year_published') ?></label>
            <input type="text" id="publication_date" name="publication_date" placeholder="<?= lang('Narrative.year_published') ?>" value="<?= esc($narrative['publication_date'] ?? $publication_date ?? '') ?>" required maxlength="32"/>

            <label><?= lang('Narrative.publication_method') . ' EN' ?></label>
            <input type="text" id="publication_mode_en" name="publication_mode_en" placeholder="<?= lang('Narrative.publication_method') . ' EN' ?>" value="<?= esc($narrative['publication_mode_en'] ?? $publication_mode_en ?? '') ?>" required maxlength="128"/>

            <label><?= lang('Narrative.publication_method') . ' FR' ?></label>
            <input type="text" id="publication_mode_fr" name="publication_mode_fr" placeholder="<?= lang('Narrative.publication_method') . ' FR' ?>" value="<?= esc($narrative['publication_mode_fr'] ?? $publication_mode_fr ?? '') ?>" required maxlength="128"/>

            <label><?= lang('Narrative.publication_point') ?></label>
            <div class="flex-row">
                <input type="text" name="publication_point_lon" placeholder="<?= lang('Narrative.longitude') ?>" value="<?= $pubPoint['longitude'] ?? $publication_point_lon ?? '' ?>" maxlength="16" required/>
                <input type="text" name="publication_point_lat" placeholder="<?= lang('Narrative.latitude') ?>" value="<?= $pubPoint['latitude'] ?? $publication_point_lat ?? '' ?>" maxlength="16" required/>
            </div>
            <input type="text" name="publication_point_place_en" placeholder="<?= lang('Narrative.location') . ' EN' ?>" value="<?= esc($pubPoint['place_en'] ?? $publication_point_place_en ?? '') ?>" maxlength="128" required/>
            <input type="text" name="publication_point_place_fr" placeholder="<?= lang('Narrative.location') . ' FR' ?>" value="<?= esc($pubPoint['place_fr'] ?? $publication_point_place_fr ?? '') ?>" maxlength="128" required/>

            <label><?= lang('Narrative.narrative_type') ?></label>
            <select id="narrative_type" name="narrative_type" required>
                <option hidden value=""><?= lang('Narrative.select_narrative_type') ?></option>
                <option value="dictated" <?php if (isset($narrative['type']) && $narrative['type'] == "dictated") echo 'selected'; else if (isset($narrative_type) && $narrative_type == "dictated") echo 'selected' ?>><?= lang('Narrative.type_dictated') ?></option>
                <option value="written" <?php if (isset($narrative['type']) && $narrative['type'] == "written") echo 'selected'; else if (isset($narrative_type) && $narrative_type == "written") echo 'selected' ?>><?= lang('Narrative.type_written') ?></option>
                <option value="biography" <?php if (isset($narrative['type']) && $narrative['type'] == "biography") echo 'selected'; else if (isset($narrative_type) && $narrative_type == "biography") echo 'selected' ?>><?= lang('Narrative.type_biography') ?></option>
            </select>

            <label><?= lang('Narrative.white_preface') . ' EN' ?></label>
            <input type="text" id="white_preface_en" name="white_preface_en" placeholder="<?= lang('Narrative.white_preface') . ' EN' ?>" value="<?= esc($narrative['white_preface_en'] ?? $white_preface_en ?? '') ?>" maxlength="32" required/>

            <label><?= lang('Narrative.white_preface') . ' FR' ?></label>
            <input type="text" id="white_preface_fr" name="white_preface_fr" placeholder="<?= lang('Narrative.white_preface') . ' FR' ?>" value="<?= esc($narrative['white_preface_fr'] ?? $white_preface_fr ?? '') ?>" maxlength="32" required/>

            <label><?= lang('Narrative.preface_details') . ' EN' ?></label>
            <input type="text" id="preface_details_en" name="preface_details_en" placeholder="<?= lang('Narrative.preface_details') . ' EN' ?>" value="<?= esc($narrative['preface_details_en'] ?? $preface_details_en ?? '') ?>" maxlength="128"/>

            <label><?= lang('Narrative.preface_details') . ' FR' ?></label>
            <input type="text" id="preface_details_fr" name="preface_details_fr" placeholder="<?= lang('Narrative.preface_details') . ' FR' ?>" value="<?= esc($narrative['preface_details_fr'] ?? $preface_details_fr ?? '') ?>" maxlength="128"/>

            <label><?= lang('Narrative.scribe_name') . ' EN' ?></label>
            <input type="text" id="scribe_editor_en" name="scribe_editor_en" placeholder="<?= lang('Narrative.scribe_name') . ' EN' ?>" value="<?= esc($narrative['scribe_editor_en'] ?? $scribe_editor_en ?? '') ?>" maxlength="128"/>

            <label><?= lang('Narrative.scribe_name') . ' FR' ?></label>
            <input type="text" id="scribe_editor_fr" name="scribe_editor_fr" placeholder="<?= lang('Narrative.scribe_name') . ' FR' ?>" value="<?= esc($narrative['scribe_editor_fr'] ?? $scribe_editor_fr ?? '') ?>" maxlength="128"/>

            <label><?= lang('Narrative.comments_histography') . ' EN' ?></label>
            <textarea id="historiography_en" name="historiography_en" placeholder="<?= lang('Narrative.comments_histography') . ' EN' ?>"  maxlength="833" rows="4" maxlength="1024"><?= esc($narrative['historiography_en'] ?? $historiography_en ?? '') ?></textarea>

            <label><?= lang('Narrative.comments_histography') . ' FR' ?></label>
            <textarea id="historiography_fr" name="historiography_fr" placeholder="<?= lang('Narrative.comments_histography') . ' FR' ?>"  maxlength="833" rows="4" maxlength="1024"><?= esc($narrative['historiography_fr'] ?? $historiography_fr ?? '') ?></textarea>

            <label><?= lang('Narrative.link') ?></label>
            <input type="text" id="link" name="link" placeholder="<?= lang('Narrative.link') ?>" value="<?= esc($narrative['link'] ?? $link ?? '') ?>" required maxlength="256"/>

            <h3><?= lang('Narrative.zone_geo') ?></h3>

            <?php
            $fieldCount = 1;
            if (isset($name_countries) && isset($type_countries)) {
                $typeCounter = 0;
                $typeLabels = array(
                    "lieuvie" => lang('Map.legend_life'),
                    "deces" => lang('Map.legend_death'),
                    "lieuvie_deces" => lang('Map.legend_life_death'),
                    "esclavage" => lang('Map.legend_slavery'),
                    "esclavage_lieuvie_deces" => lang('Map.legend_slavery_life_death'),
                    "naissance" => lang('Map.legend_birth'),
                    "naissance_esclavage" => lang('Map.legend_birth_slavery'),
                    "naissance_esclavage_lieuvie_deces" => lang('Map.legend_birth_slavery_life_death')
                );

                foreach ($name_countries as $country_name) {
                    echo '<label for="country">' . lang('Narrative.country') . '</label>
            <select id="country" name="id_country' . $fieldCount . '" required>'.
                        '<option hidden value="">' . lang('Narrative.select_country') .'</option>';
                    foreach ($countries as $country) {
                        $selected = ($country_name === $country['name']) ? 'selected' : '';
                        echo '<option value="' . $country['id'] . '" ' . $selected . '>' . $country['name'] . '</option>';
                        if($selected){
                            array_push($id_countries, $country['id']);
                        }
                    }
                    echo '</select>';
                    echo '<label for="country_type' . $fieldCount . '">' . lang('Narrative.type') . '</label>
                          <select id="country_type" name="type_country' . $fieldCount . '" required>';
                    if ($typeCounter < count($type_countries)) {
                        $type_value = $type_countries[$typeCounter];
                        $type_label = $typeLabels[$type_value];
                        $selected_type = ($type_value === $type_countries[$typeCounter]) ? 'selected' : '';
                        echo '<option value="' . $type_value . '" ' . $selected_type . '>' . $type_label . '</option>';
                        $typeCounter++;
                    }
                    foreach ($typeLabels as $value => $label) {
                        if ($value !== $type_value) {
                            echo '<option value="' . $value . '">' . $label . '</option>';
                        }
                    }
                    echo '</select>';
                    $fieldCount++;
                }
            }
            else {
                    echo '<label for="country">' . lang('Narrative.country') . '</label>
                            <select id="country" name="id_country' . $fieldCount . '" required>'.
                            '<option hidden value="">' . lang('Narrative.select_country') .'</option>';
                    foreach ($countries as $c) {
                        echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>';
                    }
                    echo '</select>';
                echo '<label for="country_type">' . lang('Narrative.type') . '</label>
                            <select id="country_type" name="type_country' . $fieldCount . '" required>
                            <option hidden value="">' . lang('Narrative.country_type') . '</option>
                            <option value="lieuvie">' . lang('Map.legend_life') . '</option>
                            <option value="deces">' . lang('Map.legend_death') . '</option>
                            <option value="lieuvie_décès">' . lang('Map.legend_life_death') . '</option>
                            <option value="esclavage">' . lang('Map.legend_slavery') . '</option>
                            <option value="esclavage_lieuvie_deces">' . lang('Map.legend_slavery_life_death') . '</option>
                            <option value="naissance_esclavage">' . lang('Map.legend_birth_slavery') . '</option>
                            <option value="naissance_esclavage_lieuvie_deces">' . lang('Map.legend_birth_slavery_life_death') . '</option>
                            </select>';
                $fieldCount++;
                }
            ?>

            <div class="flex-row" id="addNewCountries">
                <a id="addDropdown" class="button-brown"><?= lang('Narrative.add_a_geographical_area') ?></a> <!-- ne pas oublier fichier lang-->
            </div>

            <input class="submit" id="submit" type="submit" name="submit" value="<?= lang('Narrative.submit') ?>">
        </form>
    </div>

    <div id="buttoncontainer">
        <a href="<?= site_url() . "narrative/list" ?>" class="button-brown"> <?= lang('Narrative.back_to_narratives_census') ?></a>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var fieldCount = <?php
            if(isset($fieldCount))
                echo $fieldCount;
            else
                echo 2;?>;

        $("#addDropdown").click(function() {
            const newCountry = document.createElement('newCountry');
            newCountry.innerHTML = `
            <label for="country"><?= lang('Narrative.country') ?></label>
            <select id="country" name="id_country${fieldCount}" required>
            <option hidden value=""><?= lang('Narrative.select_country') ?></option>

                <?php foreach($countries as $c) { ?>
                    <option value="<?= $c['id'] ?>">
                        <?= $c['name'] ?>
                    </option>
                <?php } ?>
            </select>
            <label for="country_type"><?= lang('Narrative.type') ?></label>
            <select id="country_type" name="type_country${fieldCount}" required>
            <option hidden value=""><?= lang('Narrative.country_type') ?></option>

                <option value="lieuvie">
                    <?= lang('Map.legend_life') ?>
                </option>
                <option value="deces">
                    <?= lang('Map.legend_death') ?>
                </option>
                <option value="lieuvie_décès">
                    <?= lang('Map.legend_life_death') ?>
                </option>
                <option value="esclavage">
                    <?= lang('Map.legend_slavery') ?>
                </option>
                <option value="esclavage_lieuvie_deces">
                    <?= lang('Map.legend_slavery_life_death') ?>
                </option>
                <option value="naissance_esclavage">
                    <?= lang('Map.legend_birth_slavery') ?>
                </option>
                <option value="naissance_esclavage_lieuvie_deces">
                    <?= lang('Map.legend_birth_slavery_life_death') ?>
                </option>
            </select>
              `;
            fieldCount++;

            const buttonAddPoint = document.getElementById("addNewCountries");
            buttonAddPoint.parentNode.insertBefore(newCountry, buttonAddPoint);
            $('newCountry').contents().unwrap();
        });
    });
</script>
