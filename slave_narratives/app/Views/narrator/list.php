<div class="container">
    <br>
    <p style="text-align:center; margin-bottom:50px; font-size: 40px;"> <strong><?= lang('Narrator.title_page') ?></strong></p>

    <div class="flex-center">
        <a href="<?= site_url() . "narrative/list" ?>" class="button-brown"> <?= lang('Narrator.back_to_narratives_census') ?></a>
    </div>

    <?php

    if (!empty($narrators) && is_array($narrators)): ?>
        <table id="narrative_table" class="display" style="width:100%">
            <thead>
                <TR>    
                    <TH> <?= lang('Narratives.slave_name/narrator') ?> </TH>
                    <TH> <?= lang('Narrator.birth_year') ?> </TH>
                    <TH> <?= lang('Narrator.death_year') ?> </TH>
                    <TH> <?= lang('Narrator.freeing_ways') ?> </TH>
                    <TH> <?= lang('Narrator.parents_origin') ?> </TH>
                    <TH> <?= lang('Narrator.abolitionist') ?> </TH>
                    <TH> <?= lang('Narrator.peculiarities') ?> </TH>
                    <?php
                    if (isset($_SESSION['idAdmin'])) {?>
                    <TH> <?= lang('Narratives.edit') ?> </TH>
                    <TH> <?= lang('Narratives.delete') ?> </TH>
                    <?php } ?>

                </TR>
            </thead>
            <tbody>
                <?php foreach ($narrators as $n):?>
                <tr>
                    <td><p><?= $n['name'];?></p></td>
                    <td><p><?= $n['birth'];?></p></td>
                    <td><p><?= $n['death'];?></p></td>
                    <td><p><?= $n['freeing_ways'];?></p></td>
                    <td><p><?= $n['parents_origin'];?></p></td>
                    <td><p><?= $n['abolitionist'];?></p></td>
                    <td><p><?= $n['peculiarities'];?></p></td>
                    <?php

                    if (isset($_SESSION['idAdmin'])) {?>
                        <td>
                            <a href="<?= site_url() . 'narrator/edit/' . $n['id'] ?>">
                                <img id="crayon" src="<?= base_url(); ?>/resources/pen.png" width="40px" alt="<?= lang('Narrative.edit_img_alt') ?>" onmouseover="hover_pen_img(this);" onmouseout="unhover_pen_img(this);">
                            </a>
                        </td>
                        <td>
                            <a href="#" onclick="confirmDeleteNarrator(event, '<?= site_url()."narrator/delete/".esc($n['id'], 'url') ?>')">
                                <img id="croix" src="<?= base_url(); ?>/resources/cross.png" width="40px" alt="<?= lang('Narrative.del_img_alt') ?>" onmouseover="hover_cross_img(this);" onmouseout="unhover_cross_img(this);">
                            </a>
                        </td>
                    <?php
                    } ?>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    <?php else: ?>
        <h3><?= lang('Narrator.title_error') ?></h3>
        <p><?= lang('Narrator.message_error') ?></p>
    <?php endif ?>
</div>