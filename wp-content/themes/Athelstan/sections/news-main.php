<section id="news-main" class="section-10">
    <div class="container">
        <div class="section-10-header">
            <span class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInUp"><?php echo get_field('news_title_top', 2) ?></span>
            <div class="section-1-des-body">
                <div class="section-1-des-body-heading">
                    <?php echo get_field('news_title', 2) ?>
                </div>
                <p class="section-1-des-body-text">
                    <?php echo get_field('news_excerpt', 2) ?>
                </p>
            </div>
        </div>
        <div class="section-10-body row">
            <?php
            $id = get_queried_object_id();
            $list = new WP_Query([
                'post_type' => 'post',
                'post_status' => 'publish',
                'order' => 'DESC',
                'orderby' => 'date',
                'post__not_in' => array($id),
                'posts_per_page' => 3,
            ]);
            while ($list->have_posts()) : $list->the_post()
            ?>
                <div class="section-10-body-item-wrap col-6 col-lg-4 col-md-6">
                    <div class="section-10-body-item">
                        <div class="section-10-body-item-img">
                            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail() ?></a>
                        </div>
                        <a href="<?php the_permalink() ?>" class="section-10-body-item-heading">
                            <h3 class="margin-0 title"><?php the_title() ?></h3>
                        </a>
                        <span class="section-10-body-item-date">
                            <?php echo get_the_date('d M, Y') ?>
                        </span>
                        <p class="section-10-body-item-text">
                            <?php echo get_the_excerpt() ?>
                        </p>
                        <a href="<?php the_permalink() ?>" class="section-10-body-item-readMode">
                            Xem thêm
                            <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_query(); ?>
        </div>
    </div>
</section>