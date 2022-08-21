<section id="news-main">
    <div class="container">
        <div class="pro-header row">
            <p class="title fs-28 bg-main text-white font-m">TIN TỨC </p>
        </div>
        <div class="owl-news owl-theme owl-carousel row">
            <?php 
                $list = new WP_Query([
                    'post_type' => 'post',
                    'post_status'=>'publish',
                    'order' => 'DESC',
                    'orderby' => 'date', 
                ]);
                while($list->have_posts()) : $list->the_post()
            ?>
            <div class="item news">
                <div class="image">
                    <a href="<?php the_permalink() ?>"> <?php the_post_thumbnail() ?></a>
                </div>
                <div class="infor">
                    <h2 class="title fs-18 color-2 font-m"><?php the_title() ?></h2>
                    <p class="date"><i class="fa fa-calendar"></i><?php echo get_the_date('d M,Y') ?></p>
                    <p class="intro"><?php echo get_the_excerpt() ?></p>
                    <a href="<?php the_permalink() ?>" class="one-more color-main">Xem tất cả <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <?php endwhile;wp_reset_query(); ?>
        </div>
        <div class="more-all text-center">
            <a href="" class="bg-main text-white">Xem tất cả</a>
        </div>
    </div>
</section>