<?php
/**
 * Template Name: Chính sách
 */
get_header();
get_template_part('stn/header-main');
get_template_part('stn/breadcrumb');
?>
<section id="policy-main" class="page-policy page-detail">
    <div class="container">
        <div id="primary" class="content-policy row">
            <div class="col-lg-4">
                <div id="sidebar" class="widget_news widget_product_category">
                    <div class="list-items-sidebar list-items-product-close">
                        <span class="list-close">X</span>
                    </div>
                    <div class="category">
                        <ul class="list-category mr-t-0">
                            <?php
                                $id=get_queried_object_id(); 
                                $sales_policy=get_field('list_sales policy','option');
                                if($sales_policy):
                                    foreach($sales_policy as $sales):
                            ?>
                            <?php $parent_id=$sales['title']->ID; ?>
                            <li class="item-list <?php if($parent_id==$id){echo "active";} ?>">
                                <a href="<?php echo get_page_link( $sales['title']) ?>"><span><?php echo $sales['title']->post_title ?></span></a>
                            </li>
                            <?php endforeach;endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="news-show-sidebar">
                    <i class="fa fa-bars"></i><span>Sidebar</spanv>
                </div>
                <div class="page-content">
                    <?php while(have_posts()) : the_post() ?>
                        <?php the_content() ?>
                    <?php endwhile;wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer() ?>