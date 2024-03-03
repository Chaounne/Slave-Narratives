<br>

<div class="rec">
    <br>
    <p style="text-align:center; font-size:25px; font-style:italic;padding:6px;"><?= $narrative['title'] ?> </p>
</div>

<br>

<div class="rec">
<br>
<div class="rec_par">
<strong><p style="text-align:right;"><?= lang('Narrative.year_published') . ' :' ?></strong> <?= $narrative['publication_date'] ?> </p>
<strong><p style="text-align:right;"><?= lang('Narrative.publication_method') . ' :' ?></strong> <?= $narrative['publication_mode'] ?> </p>
<strong><p style="text-align:right;"><?= lang('Narrative.white_preface') . ' :' ?></strong> <?= $narrative['white_preface'] ?> </p>
<strong><p style="text-align:right;"><?= lang('Narrative.preface_details') . ' :' ?></strong> <?= $narrative['preface_details'] ?> </p>
<strong><p style="text-align:right;"><?= lang('Narrator.has_wrote_several_narratives') . ' :' ?></strong> <?php if ($narrator['has_wrote_several_narratives'] == 0) echo lang('Narrator.no'); else echo lang('Narrator.yes'); ?>

<strong><p><?= lang('Narrator.name') . ' :' ?></strong> <?= $narrator['name'] ?> </p>
<strong><p><?= lang('Narrative.narrative_type') . ' :' ?></strong> <?= lang('Narrative.type_'.$narrative['type']) ?> </p>
<strong><p><?= lang('Narrator.birth_year') . ' :' ?></strong> <?= $narrator['birth'] ?> </p>
<strong><p><?= lang('Narrator.death') . ' :' ?></strong> <?= $narrator['death'] ?> </p>
<strong><p><?= lang('Narrator.freeing_ways') . ' :' ?></strong> <?= $narrator['freeing_ways'] ?> </p>
<strong><p><?= lang('Narrator.parents_origin') . ' :' ?></strong> <?= $narrator['parents_origin'] ?> </p>
<strong><p><?= lang('Narrative.scribe_name') . ' :' ?></strong> <?= $narrative['scribe_editor'] ?> </p>
<strong><p><?= lang('Narrator.abolitionist') . ' :' ?></strong> <?= $narrator['abolitionist'] ?> </p>
<strong><p><?= lang('Narrator.peculiarities') . ' :' ?></strong> <?= $narrator['peculiarities'] ?> </p>
</div>

<div id="comm">
<p style="text-align:center;"><?= lang('Narrative.comments_histography') . ' :' ?><br><br> <?= nl2br($narrative['historiography']) ?></p>

</div>

    <br>

    <p><?= lang('Narrative.link') . ' :' ?> <a href="<?= $narrative['link'] ?>"><?= $narrative['link'] ?></a></p>

    <div id="buttoncontainer">
    <?php if (isset($_SESSION['idAdmin'])) {?>
        <a href="<?= site_url() . "narrative/edit/" . $narrative['id'] ?>" class="button-brown" onmouseover="hover_pen_link(this);" onmouseout="unhover_pen_link(this);"><?= lang('Narrative.edit_narrative_title') ?> <img src="<?= base_url(); ?>/resources/pen.png" width="30px" alt="+"></a>
        <a href="<?= site_url() . "narrator/edit/" . $narrative['id_narrator'] ?>" class="button-brown" onmouseover="hover_pen_link(this);" onmouseout="unhover_pen_link(this);"><?= lang('Narrator.edit_button') ?> <img src="<?= base_url(); ?>/resources/pen.png" width="30px" alt="+"></a>
        <a href="#" onclick="confirmDeleteNarrative(event, '<?= site_url()."narrative/delete/".esc($narrative['id'], 'url')."/".esc($narrative['id_narrator'], 'url') ?>')" class="button-brown" onmouseover="hover_cross_link(this);" onmouseout="unhover_cross_link(this);"><?= lang('Narrative.delete_narrative') ?> <img src="<?= base_url(); ?>/resources/cross.png" width="30px" alt="-"></a>
        <a href="#" onclick="confirmDeleteNarrator(event, '<?= site_url()."narrator/delete/".esc($narrative['id_narrator'], 'url') ?>')" class="button-brown" onmouseover="hover_cross_link(this);" onmouseout="unhover_cross_link(this);"><?= lang('Narrator.delete') ?> <img src="<?= base_url(); ?>/resources/cross.png" width="30px" alt="-"></a>
    <?php } ?>
    </div>

    <div id="buttoncontainer">
        <button class="exportPDFAndDelete" id="exportPDF">
            <?= lang('Narrative.pdf_export') ?>
            <img src="<?= base_url(); ?>/resources/pdf.png" alt="Icône PDF" style="width: 30px; margin-left: 10px;">
        </button>
        <a href="<?= site_url('?narrative='.$narrative['id']) ?>" class="button-brown"> <?= lang('Map.see_map_of_this_narrative') ?></a>
    </div>

    <!--content of the PDF file-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('exportPDF').addEventListener('click', function() {
                var doc = new jsPDF();

                var maxWidth = 210; 
                var fontSize = 15; 

                var titre = document.querySelector('.rec p').textContent;
                var contenu = document.querySelector('.rec_par').textContent;
                var comments = document.getElementById('comm').textContent;
                var link = document.querySelector('.rec p a').textContent;
                var contentToPrint = '\n' + contenu + '\n' + comments;

                var titreLines = doc.splitTextToSize(titre, maxWidth);
                var lines = doc.splitTextToSize(contentToPrint, maxWidth);
                var linkLines = doc.splitTextToSize(link, maxWidth);

                doc.setFont("goudy");
                doc.setFontStyle("italic");
                doc.setFontSize(fontSize);

                doc.text(titreLines, 15, 15, { align: 'justify' });

                doc.setFontStyle("normal");

                // Calculate the height of the title text
                var titreHeight = doc.getTextDimensions(titreLines).h;

                doc.text(lines, 15, titreHeight + 10);

                doc.setTextColor(0, 0, 255); 

                doc.text(linkLines, 15, doc.internal.pageSize.height - 30); // Position at the bottom of the page, less a small margin (30)

                doc.save('<?= $narrative['title_beginning'] ?>' + '.pdf');

            });
        });

    </script>
</div>