<aside id="sidebar" class="widget_news widget_scroll">
    <div class="list-items-sidebar list-items-news-close">
        <span class="list-close">X</span>
    </div>
    <div class="news-new">
        <div class="news-all">
            <p class="title fs-20 font-b mr-b-0">
                Bài Viết Mới Nhất
            </p>
            <div class="list-news-sibar items-news">
                <?php
                $id = get_queried_object_id();
                $args = array(
                    'type'      => 'post',
                    'orderby' => 'ID',
                    'order' => 'DESC',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'post__not_in' => array($id)
                );
                $list = new WP_Query($args);
                while ($list->have_posts()) : $list->the_post()
                ?>
                    <div class="items">
                        <div class="date">
                            <i class='bx bx-time-five'></i><?php echo get_the_date('d') . " tháng " . get_the_date('m') . ", " . get_the_date('Y')  ?>
                        </div>
                        <div class="text">
                            <h2 class="fs-16 font-m"> <a href="<?php the_permalink() ?>" class="title color-2"><?php the_title() ?></a></h2>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_query(); ?>
            </div>
        </div>
    </div>
    <div class="contact" style="background-image: url('<?php echo get_field('single_background', 'option')['url'] ?>')">
        <div class="elementor-background-overlay"></div>
        <div class="position">
            <h3 class="title"><?php echo get_field('single_title', 'option') ?></h3>
            <p class="excerpt"><?php echo get_field('single_content', 'option') ?></p>
            <a href="<?php echo get_field('single_link_button', 'option') ?>" class="btn btn-custom not-flex"><?php echo get_field('single_text_button', 'option') ?></a>
        </div>
    </div>
    <?php
    $id = get_queried_object_id();
    $args = array(
        'type'      => 'post',
        'child_of'  => 0,
        'hide_empty'  => true,
    );
    $categories = get_categories( $args );
    if ($categories && count($categories) > 0) :
    ?>
        <div class="category">
            <p class="title fs-20 font-b mr-b-0">
                Categories
            </p>
            <ul>
                <?php
                foreach ($categories as $categ) :
                ?>
                    <li>
                        <i class='bx bx-chevron-right' ></i><a href="<?php echo get_category_link($categ->term_id); ?>" class="font-m"><?php echo $categ->name; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</aside>