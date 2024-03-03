//datatable
$(document).ready(function () {
    new DataTable('#narrative_table');
});

//change image on hover
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

//delete narrative & narrator
function confirmDeleteNarrative(e, deleteUrl) {
    e.preventDefault();
    var confirmation = confirm("<?= lang('Narrative.delete_confirmation') ?>");

    if (confirmation) {
        window.location.href = deleteUrl;
    }
}

function confirmDeleteNarrator(e, deleteUrl) {
    e.preventDefault();
    const confirmation = confirm("<?= lang('Narrator.confirm_delete') ?>");

    if (confirmation) {
        window.location.href = deleteUrl;
    }
}