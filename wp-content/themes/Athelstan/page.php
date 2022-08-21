<?php
get_header();
get_template_part('stn/header-main');
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
				the_content();
				endwhile; // End the loop.
				?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
