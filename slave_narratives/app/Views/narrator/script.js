//datatable
$(document).ready(function () {
    new DataTable('#narrative_table');
});

//create a new point
let nbOfPoint = 0;

function createNewPoint(point = null) {
    const newPoint = document.createElement('newPoint');

    let lon = ""
    let lat = ""
    let type = ""
    let place_en = ""
    let place_fr = ""

    if (point != null) {
        lon = point['longitude']
        lat = point['latitude']
        type = point['type']
        place_en = point['place_en'].replaceAll('"', "\&#34;")
        place_fr = point['place_fr'].replaceAll('"', "\&#34;")
    }

    newPoint.innerHTML = `
    <label for="point_`+nbOfPoint+`"><?= lang('Narrator.point') . " n°`+(nbOfPoint+1)+`" ?></label>
    <select id="point_`+nbOfPoint+`" name="point_`+nbOfPoint+`_type" required>
        <option hidden value=""><?= lang('Narrator.select_point_type') ?></option>
        <option value="birth" `+(type !== "" && type === "birth" ? 'selected' : "")+`><?= lang('Narrator.birth') ?></option>
        <option value="death" `+(type !== "" && type === "death" ? 'selected' : "")+`><?= lang('Narrator.death') ?></option>
        <option value="slavery" `+(type !== "" && type === "slavery" ? 'selected' : "")+`><?= lang('Narrator.slavery') ?></option>
        <option value="life" `+(type !== "" && type === "life" ? 'selected' : "")+`><?= lang('Narrator.life') ?></option>
    </select>
    <div class="flex-row">
        <input type="text" id="point_`+nbOfPoint+`" name="point_`+nbOfPoint+`_lat" placeholder="<?= lang('Narrative.latitude') ?>" value="`+lat+`" maxlength="16" required/>
        <input type="text" id="point_`+nbOfPoint+`" name="point_`+nbOfPoint+`_lon" placeholder="<?= lang('Narrative.longitude') ?>" value="`+lon+`" maxlength="16" required/>
    </div>
    <input type="text" id="point_`+nbOfPoint+`" name="point_`+nbOfPoint+`_place_en" placeholder="<?= lang('Narrative.location') . ' EN' ?>" value="`+place_en+`" maxlength="128" required/>
    <input type="text" id="point_`+nbOfPoint+`" name="point_`+nbOfPoint+`_place_fr" placeholder="<?= lang('Narrative.location') . ' FR' ?>" value="`+place_fr+`" maxlength="128" required/>
    `;

    nbOfPoint++;
    const buttonAddPoint = document.getElementById("addNewPoints");
    buttonAddPoint.parentNode.insertBefore(newPoint, buttonAddPoint);
    $('newPoint').contents().unwrap();
}

// Change image on hover
function hover_cross_img(element) {
    element.setAttribute('src', "<?= site_url() . 'resources/cross_hovered.png' ?>");
}

function unhover_cross_img(element) {
    element.setAttribute('src', "<?= site_url() . 'resources/cross.png' ?>");
}

function hover_cross_link(element) {
    hover_cross_img(element.children[0]);
}

function unhover_cross_link(element) {
    unhover_cross_img(element.children[0]);
}

function hover_pen_img(element) {
    element.setAttribute('src', "<?= site_url() . 'resources/pen_hovered.png' ?>");
}

function unhover_pen_img(element) {
    element.setAttribute('src', "<?= site_url() . 'resources/pen.png' ?>");
}

function unhover_pen_link(element) {
    unhover_pen_img(element.children[0]);
}

function hover_pen_link(element) {
    hover_pen_img(element.children[0]);
}

//delete narrator
function confirmDeleteNarrator(e, deleteUrl) {
    e.preventDefault();
    const confirmation = confirm("<?= lang('Narrator.confirm_delete') ?>");

    if (confirmation) {
        window.location.href = deleteUrl;
    }
}