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
                        <?php
                            //Declare Vars
                            $comment_send = 'Bình luận';
                            $comment_reply = 'Để lại lời nhắn';
                            $comment_reply_to = 'Trả lời';
                            
                            $comment_author = 'Họ tên';
                            $comment_email = 'E-Mail';
                            $comment_body = 'Bình luận';
                            $comment_url = 'Trang web';
                            $comment_cookies_1 = ' Lưu tên, email và trang web của tôi trong trình duyệt này cho lần tôi nhận xét tiếp theo.';
                            $comment_cookies_2 = ' Chính sách bảo mật';
                            
                            $comment_before = 'Địa chỉ email của bạn sẽ không được công bố. Các trường bắt buộc được đánh dấu *';
                            
                            $comment_cancel = 'Huỷ Trả Lời';
                            
                            //Array
                            $comments_args = array(
                                //Define Fields
                                'fields' => array(
                                    //Author field
                                    'author' => '<p class="comment-form-author"><br /><input id="author" name="author" aria-required="true" placeholder="' . $comment_author .'"></input></p>',
                                    //Email Field
                                    'email' => '<p class="comment-form-email"><br /><input id="email" name="email" placeholder="' . $comment_email .'"></input></p>',
                                    //URL Field
                                    'url' => '<p class="comment-form-url"><br /><input id="url" name="url" placeholder="' . $comment_url .'"></input></p>',
                                    //Cookies
                                    'cookies' => '<input type="checkbox" required>' . $comment_cookies_1 . '<a href="' . get_privacy_policy_url() . '">' . $comment_cookies_2 . '</a>',
                                ),
                                // Change the title of send button
                                'label_submit' => __( $comment_send ),
                                // Change the title of the reply section
                                'title_reply' => __( $comment_reply ),
                                // Change the title of the reply section
                                'title_reply_to' => __( $comment_reply_to ),
                                //Cancel Reply Text
                                'cancel_reply_link' => __( $comment_cancel ),
                                // Redefine your own textarea (the comment body).
                                'comment_field' => '<p class="comment-form-comment"><br /><textarea id="comment" name="comment" aria-required="true" placeholder="' . $comment_body .'"></textarea></p>',
                                //Message Before Comment
                                'comment_notes_before' => __( $comment_before),
                                // Remove "Text or HTML to be displayed after the set of comment fields".
                                'comment_notes_after' => '',
                                //Submit Button ID
                                'id_submit' => __( 'comment-submit' ),
                            );
                            // comment_form( $comments_args );
                        ?>
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