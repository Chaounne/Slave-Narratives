<div class="sidebar">
	<!-- Search by place type -->
	<?php 
		echo "<p>" . lang('Map.label_type_place') . "</p>";
	?>

	<form method="get">
		<select name="place" id="select">
            <?php if (empty($_GET['place'])) { ?>
                <option hidden value=""><?= lang('Map.label_type_place') ?></option>
            <?php } ?>

			<option value="birth" <?php if (isset($place) && $place == 'birth') echo 'selected' ?>><?= lang('Map.option_birth')?></option>
			<option value="publication" <?php if (isset($place) && $place == 'publication') echo 'selected' ?>><?= lang('Map.option_publication')?></option>
			<option value="death" <?php if (isset($place) && $place == 'death') echo 'selected' ?>><?= lang('Map.option_death')?></option>
			<option value="slavery" <?php if (isset($place) && $place == 'slavery') echo 'selected' ?>><?= lang('Map.option_slavery')?></option>
			<option value="life" <?php if (isset($place) && $place == 'life') echo 'selected' ?>><?= lang('Map.option_life')?></option>
		</select>
		<br><br>
		<input id="cc"  type="submit" value="<?= lang('Map.research')?>" />
	</form>

	<br>

	<!-- Search by narrative -->
	<?php 
		echo "<p>" . lang('Map.label_narrative') . "</p>";
	?>

	<form method="get">
		<select name="narrative" id="select">
			<?php if (empty($_GET['narrative'])) { ?>
				<option hidden value=""><?= lang('Map.label_narrative') ?></option>
			<?php }

			foreach($nar_points as $p){ ?>
				<option value="<?= $p['id_narrative'] ?>" <?php if (isset($narrativeId) && $narrativeId == $p['id_narrative']) echo 'selected' ?>>
					<?= $p['name'],' (', $p['publication_date'],')' ?>
				</option>
            <?php } ?>
		</select>
		<br><br>
		<input id="cc"  type="submit" value="<?= lang('Map.research')?>" />
	</form>

	<br>

	<section class= "legend2">
		<span><p> <?= lang('Map.legend_title')?> </p></span>
		<i class="naissance"></i><span><?= lang('Map.legend_birth')?></span><br>
		<i class="publi"></i><span><?= lang('Map.legend_publication')?></span><br>
		<i class="lieuvie"></i><span><?= lang('Map.legend_life')?></span><br>
		<i class="deces"></i><span><?= lang('Map.legend_death')?></span><br>
		<i class='esclavage'></i><span><?= lang('Map.legend_slavery')?></span><br>

		<i class='naiss_esc'></i><span><?= lang('Map.legend_birth_slavery')?></span><br>
		<i class='lieuvie_dec'></i><span><?= lang('Map.legend_life_death')?></span><br>
		<i class='esc_vie_dec'></i><span><?= lang('Map.legend_slavery_life_death')?></span><br>
		<i class='naiss_esc_vie_dec'></i><span><?= lang('Map.legend_birth_slavery_life_death')?></span><br>
		<br>
		<i class='usa'></i><span><?= lang('Map.legend_us_borders')?></span><br>
	</section>

</div>
