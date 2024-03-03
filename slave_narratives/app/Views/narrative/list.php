<div class="container">
    <br>
    <p style="text-align:center; margin-bottom:50px; font-size: 40px;"> <strong><?= lang('Narratives.title_page') ?></strong></p>

    <?php

    if (isset($_SESSION['idAdmin'])) {?>

    <div class="flex-center">
        <a href="<?= site_url() . "narrator/create" ?>" class="button-brown"><?= lang('Narratives.create_narrator') ?> <img src="<?= base_url(); ?>/resources/plus.png" width="30px" alt="+"></a>
        <a href="<?= site_url() . "narrative/create" ?>" class="button-brown"><?= lang('Narratives.create_narrative') ?> <img src="<?= base_url(); ?>/resources/plus.png" width="30px" alt="+"></a>
        <a href="<?= site_url() . "narrator/list" ?>" class="button-brown"><?= lang('Narratives.narrator_census') ?></a>
    </div>

    <?php
    }
    else {?>
        <div class="flex-center">
        <a href="<?= site_url() . "narrator/list" ?>" class="button-brown"><?= lang('Narratives.narrator_census') ?></a>
    </div>
    <?php
    }

    if (!empty($narratives) && is_array($narratives)): ?>
        <table id="narrative_table" class="display" style="width:100%">
            <thead>
                <TR>
                    <TH> <?= lang('Narratives.slave_name/narrator') ?> </TH>
                    <TH> <?= lang('Narratives.publication_date') ?> </TH>
                    <TH> <?= lang('Narratives.title') ?> </TH>
                    <?php
                    if (isset($_SESSION['idAdmin'])) {?>
                        <TH> <?= lang('Narratives.edit') ?> </TH>
                        <TH> <?= lang('Narratives.delete') ?> </TH>
                    <?php } ?>
                </TR>
            </thead>
            <tbody>
                <?php foreach ($narratives as $n): 
                ?>
                <tr>
                    <td>
                        <p><a href="<?= site_url()."narrative/".esc($n['id_narrative'], 'url') ?>"><?= $n['name'];?></a></p>
                    </td>
                    <td>
                        <p><?= $n['publication_date'];?></p>
                    </td>
                    <td>
                        <p><i><?= $n['title'];?></i></p>
                    </td>
                    <?php
                    //narrative's actions
                    if (isset($_SESSION['idAdmin'])) {?>

                    <td>
                        <a href="<?= site_url() . 'narrative/edit/' . $n['id_narrative'] ?>">
                            <img id="crayon" src="<?= base_url(); ?>/resources/pen.png" width="40px" alt="<?= lang('Narrative.edit_img_alt') ?>" onmouseover="hover_pen_img(this);" onmouseout="unhover_pen_img(this);">
                        </a>    
                    </td>
                    <td>
                        <a href="#" onclick="confirmDeleteNarrative(event, '<?= site_url()."narrative/delete/".esc($n['id_narrative'], 'url')."/".esc($n['id_narrator'], 'url') ?>')" >
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
        <h3><?= lang('Narratives.title_error') ?></h3>
        <p><?= lang('Narratives.message_error') ?></p>
    <?php endif ?>
</div>