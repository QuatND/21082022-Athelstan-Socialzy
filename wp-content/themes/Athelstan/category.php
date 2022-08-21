<?php
get_header();
?>
    <section id="news-page">
        <div class="container">
            <?php $term = get_queried_object(); ?>
            <?php $image = get_field('banner_category_post', $term); ?>
            <?php if ($image != ''): ?>
                <div class="banner-description">
                    <div class="banner">
                        <img src="<?php echo $image ['url'] ?>" alt="<?php echo $image ['alt'] ?>">
                    </div>
                    <p class="description">
                        <?php echo get_field('description_category_post', $term) ?>
                    </p>
                </div>
            <?php endif; ?>
            <div class="news-post row">
                <div class="col-xl-9 col-lg-8">
                    <p class="title-post-category">
                        <?php echo $term -> name ?>
                    </p>
                    <div class="post-category">
                        <?php
                        $id = get_queried_object_id();
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $list = new WP_Query([
                            'post_type' => 'post',
                            'posts_per_page' => 8,
                            'cat' => $id,
                            'paged' => $paged,
                        ]);
                        while ($list->have_posts()) : $list->the_post()
                            ?>
                            <div class="item-post row">
                                <div class="col-sm-5">
                                    <div class="image">
                                        <a href="<?php the_permalink() ?>">
                                            <?php the_post_thumbnail() ?>
                                        </a>
                                        <div class="date">
                                            <img src="<?php echo get_stylesheet_directory_uri() ?>/images/clock_24px.svg"
                                                 alt="clock">
                                            <?php echo get_the_date() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="title-description">
                                        <div class="title">
                                            <a href="<?php the_permalink() ?>">
                                                <?php echo get_the_title(); ?>
                                            </a>
                                        </div>
                                        <p class="description">
                                            <?php echo get_the_excerpt() ?>
                                        </p>
                                        <a class="see-more" href="<?php the_permalink() ?>">
                                            Đọc thêm
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_query(); ?>
                    </div>
                    <?php //if (function_exists('devvn_wp_corenavi')) devvn_wp_corenavi($list); ?>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <?php get_template_part('sidebar-news') ?>
                </div>
            </div>
        </div>
    </section>
<?php get_footer() ?>