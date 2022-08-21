<section id="banner-main" class="section-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="section-1-des">
                    <span class="section-1-des-welcome animate__animated animate__bounce animate__delay-1s animate__slow animate__fadeInLeft"><?php echo get_field('banner_title_top', get_the_id()); ?></span>
                    <div class="section-1-des-body">
                        <div class="section-1-des-body-heading">
                            <?php echo get_field('banner_title', get_the_id()); ?>
                        </div>
                        <p class="section-1-des-body-text  animate__animated animate__bounce animate__delay-1s animate__slow animate__fadeInRight">
                            <?php echo get_field('banner_except', get_the_id()); ?>
                        </p>
                        <div class="section-1-des-body-btn">
                            <a href="<?php echo get_field('banner_link', get_the_id())['link']; ?>" class="btn btn-custom  animate__animated animate__bounce animate__delay-1s animate__slow animate__fadeInLeft">
                                <?php echo get_field('banner_link', get_the_id())['text']; ?>
                                <i class="bx bx-right-arrow-circle"></i>
                            </a>
                            <div class="btn-video-wrap">
                                <div class="btn-video" data-videoModal="<?php echo image_iframe_youtube(get_field('banner_watch', get_the_id())['link'])['link_embed'] ?>" data-target="#video-modal">
                                    <a class="btn-video-intro animate__animated animate__bounce animate__delay-1s animate__slow animate__fadeInRight">
                                        <i class="bx bxs-right-arrow"></i>
                                    </a>
                                    <a class="text-video-intro animate__animated animate__bounce animate__delay-1s animate__slow animate__fadeInRight"> <?php echo get_field('banner_watch', get_the_id())['text']; ?> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="customer-reviews">
                        <div class="list-customer">
                            <?php $images = get_field('banner_customer', get_the_id())['images'];
                            if (count($images) > 0) :
                            foreach($images as $image):
                            ?>
                            <img src="<?php echo $image['image']['url'] ?>" alt="<?php echo $image['image']['alt'] ?>" />
                            <?php endforeach;endif; ?>
                        </div>
                        <div class="number-preview"><?php echo get_field('banner_customer', get_the_id())['text']; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="section-1-banner">
                    <div class="section-1-banner-img-wap">
                        <div class="section-1-banner-img"></div>
                    </div>
                    <img src="<?php echo get_field('banner_image_right', get_the_id())['url'] ?>" alt="<?php echo get_field('banner_image_right', get_the_id())['alt'] ?>" />
                    <div class="section-1-banner-contact">
                        <div class="section-1-banner-contact-facebook section-1-banner-contact-shared">
                            <i class="bx bxl-facebook"></i>
                        </div>
                        <div class="section-1-banner-contact-youtube section-1-banner-contact-shared">
                            <i class="bx bxl-youtube"></i>
                        </div>
                        <div class="section-1-banner-contact-tikTok section-1-banner-contact-shared">
                            <i class="bx bxl-tiktok"></i>
                        </div>
                        <div class="section-1-banner-contact-twitter section-1-banner-contact-shared">
                            <i class="bx bxl-twitter"></i>
                        </div>
                        <div class="section-1-banner-contact-instagram section-1-banner-contact-shared">
                            <i class="bx bxl-instagram-alt"></i>
                        </div>
                    </div>
                    <div class="wow section-1-banner-statistical Brands-Joined animate__animated animate__bounce animate__delay-1s animate__slow animate__fadeInLeft">
                        <div class="section-1-banner-statistical-icon">
                            <?php echo get_field('banner_brands_joined', get_the_id())['icon'] ?>
                        </div>
                        <div class="section-1-banner-statistical-number">
                            <?php echo get_field('banner_brands_joined', get_the_id())['number'] ?>
                            <span><?php echo get_field('banner_brands_joined', get_the_id())['text'] ?></span>
                        </div>
                    </div>
                    <div class="wow section-1-banner-statistical Sales-Growth animate__animated animate__bounce animate__delay-1s animate__slow animate__fadeInRight">
                        <div class="section-1-banner-statistical-icon">
                            <?php echo get_field('banner_sales_growth', get_the_id())['icon'] ?>
                        </div>
                        <div class="section-1-banner-statistical-number">
                            <?php echo get_field('banner_sales_growth', get_the_id())['number'] ?>
                            <span><?php echo get_field('banner_sales_growth', get_the_id())['text'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>