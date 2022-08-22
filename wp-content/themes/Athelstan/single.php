<?php
get_header();
?>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v4.0"></script>
<?php
get_template_part('sections/header-main');
get_template_part('sections/breadcrumb');
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container pading-0 ">
            <div class="row">
                <div class="col-lg-8 col-12 ScrollMagic">
                    <div class="news-show-sidebar">
                        <i class="fa fa-bars"></i><span>Danh mục</spanv>
                    </div>
                    <div class="page-content">
                        <div class="image-main">
                        <?php the_post_thumbnail() ?>
                        </div>
                        <div class="excerpt font-m color-2 fs-18">
                            <?php echo the_excerpt(); ?>
                        </div>
                        <?php while (have_posts()): the_post();
								the_content();
							endwhile; ?>
                        <div class="tag-share">
                            <div class="tags">
                                <div class="title">Tags bài viết:</div>
                                <div class="items">
                                    <?php
                                    $id = get_queried_object_id();
                                    $categories = get_the_tags($id);
                                    if(is_array($categories)):
                                    foreach($categories as $categ):
                                    ?>
                                    <a href="<?php echo get_category_link($categ->term_id); ?>" class="font-m"><?php echo $categ->name; ?></a>
                                    <?php endforeach;endif; ?>
                                </div>
                            </div>
                            <div class="share">
                                <div class="title">Chia sẻ</div>
                                <div class="items">
                                    <a href="https://www.facebook.com/sharer.php?u=<?php the_permalink()?>" target="_blank" class="item"><i class="fa fa-facebook"></i></a>
                                    <a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title() ?>;url=<?php the_permalink() ?>" target="_blank" class="item"><i class="fa fa-twitter"></i></a>
                                    <a href="https://api.whatsapp.com/send?text=<?php the_permalink()?>" target="_blank" class="item"><i class="fa fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="single-commemt">
                            <?php comments_template('/comment.php'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?php get_template_part('sidebar-single') ?>
                </div>
            </div>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->
<?php
get_template_part('stn/news-main');
get_footer();