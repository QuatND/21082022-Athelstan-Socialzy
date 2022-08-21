<?php
get_header();
get_template_part('stn/header-main');
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">
			<?php
				the_content();
			?>
			</div>
		</main>
	</div>

<?php
get_footer();
