<?php
get_header();
get_template_part('sections/header-main');
?>
<div id="primary" class="content-area page-404">
	<div class="elementor-background-overlay" style="background-image: url('<?php echo get_template_directory_uri() ?>/images/bg-footer.webp')"></div>
	<main id="main" class="site-main">
		<div class="container">
			<div class="error-404 not-found">
				<header class="page-header color-main text-center">
					<h1 class="page-title">404</h1>
					<p class="section-1-des-body-heading">Trang không tồn tại</p>
					<div class="text">Trang bạn đang tìm kiếm đã bị di chuyển, xóa, đổi tên hoặc không bao giờ tồn tại.</div>
					<a href="<?php echo home_url() ?>" class="btn btn-custom not-flex">Trờ về trang chủ</a>
				</header><!-- .page-header -->
			</div><!-- .error-404 -->
		</div>
	</main><!-- #main -->
</div><!-- #primary -->
