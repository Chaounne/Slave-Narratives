<?php
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<br>
<footer>
	<div class="text-center">
		<a class="navbar-brand <?= ($current_page == "about") ? 'active' : '' ?>" href="<?= site_url()."about" ?>" ><?= lang('HeaderFooter.about')?></a>
		<a class="navbar-brand <?= ($current_page == "contact") ? 'active' : '' ?>" href="<?= site_url()."contact" ?>" ><?= lang('HeaderFooter.contact')?></a>
	</div>
</footer>