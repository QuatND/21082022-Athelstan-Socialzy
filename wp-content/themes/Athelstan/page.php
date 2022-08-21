<?php
get_header();
get_template_part('sections/header-main');
get_template_part('sections/breadcrumb');
?>
<div id="primary" class="content-area page-default">
    <div class="container">
        <div class="rows">
            <div class="page-content">
            <?php while (have_posts()): the_post();
                the_content();
            endwhile; ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();