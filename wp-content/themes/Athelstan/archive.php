<?php
get_header();
get_template_part('stn/header-main');
get_template_part('stn/breadcrumb');
?>
	<div id="primary" class="content-area page-default">
		<main id="main" class="site-main">
			<div class="container">
				<div class="page-content">
				<?php if ( have_posts() ) : ?>
				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
					?>
				</header><!-- .page-header -->
				<?php
				// Start the Loop.
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Format-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that
					* will be used instead.
					*/
					get_template_part( 'template-parts/content/content', 'excerpt' );

					// End the loop.
				endwhile;
				// Previous/next page navigation.
				// If no content, include the "No posts found" template.
				else :
				endif;
				?>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
