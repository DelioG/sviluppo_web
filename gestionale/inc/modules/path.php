<!-- Questo file consente di inserire nelle pagine la stampa del path -->
<!-- Es: Home > Pagina X -->
<div class="path">
	<p>
		<a href="<?= $link_home; ?>">Home</a>
		<?php
			if ( $page_name != $title_home )
			{
		?>
			> <?= $page_name; ?>
		<?php
			}
		?>
	</p>
</div> <!-- path -->