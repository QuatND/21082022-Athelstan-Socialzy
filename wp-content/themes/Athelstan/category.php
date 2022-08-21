<?php
get_header();
get_template_part('sections/header-main');
get_template_part('sections/breadcrumb');
?>
<section id="news-page">
    <div id="primary" class="container content-area">
        <div id="news-main" class="news-post">
            <div class="row">
                <div class="col-lg-8 ScrollMagic">
                    <div class="news-show-sidebar">
                        <i class="fa fa-bars"></i><span>Danh mục</spanv>
                    </div>
                    <?php
                    $id = get_queried_object_id();
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $list = new WP_Query([
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'cat' => $id,
                        'paged' => $paged,
                    ]);
                    while ($list->have_posts()) : $list->the_post()
                    ?>
                        <div class="blog__content">
                            <div class="blog__content--img">
                                <a href="<?php the_permalink() ?>"><?php the_post_thumbnail() ?></a>
                            </div>
                            <div class="blog__content--des">
                               <p class="blog__content--des--category text"><a href="<?php echo get_category_link(get_the_category(get_the_id())[0]->term_id); ?>"><?php echo get_the_category(get_the_id())[0]->name ?? ''; ?></a></p>
                                <a href="<?php the_permalink() ?>" class="heading">
                                    <?php the_title() ?>
                                </a>
                                <p class="text">
                                    <?php echo get_the_excerpt() ?>
                                </p>
                            </div>
                            <a href="<?php the_permalink() ?>" class="blog__content--read-more">Xem thêm
                                <i class="bx bx-right-arrow-alt"></i>
                            </a>
                        </div>
                    <?php endwhile;
                    wp_reset_query(); ?>
                    <?php if (function_exists('althelstan_wp_corenavi')) althelstan_wp_corenavi($list); ?>
                </div>
                <div class="col-lg-4">
                    <?php get_template_part('sidebar-single') ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer() ?>