<aside id="sidebar" class="widget_news widget_scroll">
    <div class="list-items-sidebar list-items-news-close">
        <span class="list-close">X</span>
    </div>
    <div class="category">
        <h2 class="title fs-20 font-b mr-b-0">
            DANH MỤC TIN TỨC
        </h2>
        <ul>
            <?php
            $args = array(
                'type'      => 'post',
                'child_of'  => 0,
                'hide_empty'  => false,
            );
            $categories = get_categories( $args );
            if(count($categories)>0):
            foreach($categories as $categ):
            ?>
            <li>
                <a href="<?php echo get_category_link($categ->term_id); ?>" class="font-m">
                    <h4 class="fs-16 mr-b-0"><?php echo $categ->name; ?></h4>
                </a>
            </li>
            <?php endforeach;endif; ?>
        </ul>
    </div>
    <div class="news-new">
        <div class="news-all">
            <h2 class="title fs-20 font-b mr-b-0">
                BÀI VIẾT NỔI BẬT
            </h2>
            <div class="list-news-sibar items-news">
                <?php
                $id=get_queried_object_id();
                $args = array(
                    'type'      => 'post',
                    'orderby' => 'ID',
                    'order' => 'DESC',
                    'post_status'=>'publish',
                    'posts_per_page' => 5, 
                );
                $list=new WP_Query($args);
                while($list->have_posts()) : $list->the_post()
                ?>
                <div class="items">
                    <div class="image">
                        <a href="<?php the_permalink() ?>">
                        <?php the_post_thumbnail() ?>
                        </a>
                    </div>
                    <div class="text">
                        <h3 class="fs-16 font-m"> <a href="<?php the_permalink() ?>"
                                class="title color-2"><?php the_title() ?></a></h3>
                    </div>
                </div>
                <?php endwhile;wp_reset_query(); ?>
            </div>
        </div>
    </div>
    <div class="tags">
        <h2 class="title fs-20 font-b mr-b-0">
            TAGS
            </h2>
        <ul>
            <?php
            $args = array(
                'type'      => 'post',
                'child_of'  => 0,
                'hide_empty'  => false,
            );
            $categories = get_tags( $args );
            if(count($categories)>0):
            foreach($categories as $categ):
            ?>
            <li>
                <a href="<?php echo get_category_link($categ->term_id); ?>" class="font-m"><?php echo $categ->name; ?></a>
            </li>
            <?php endforeach;endif; ?>
        </ul>
    </div>
</aside>