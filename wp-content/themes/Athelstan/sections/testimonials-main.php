<section id="testimonials-main" class="section-9">
    <div class="elementor-background-overlay" style="background-image: url('<?php echo get_field('footer_background', 'option')['url'] ?>')"></div>
    <div class="container">
        <div class="row section-9-header">
            <div class="col-lg-6 col-sm-6 col-12 section-9-header-left">
                <span class="section-1-des-welcome wow animate__animated animate__bounce animate__slow animate__fadeInLeft"><?php echo get_field('testimonials_title_top', 2) ?></span>
                <div class="section-1-des-body">
                    <div class="section-1-des-body-heading">
                        <?php echo get_field('testimonials_title', 2) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-12 section-9-header-right">
                <p>
                    <?php echo get_field('testimonials_excerpt', 2) ?>
                </p>
            </div>
        </div>
        <div class="row section-9-body wow animate__animated animate__slow animate__fadeInUp">
            <div class="col-lg-6 col-md-12 col-12">
                <div class="section-9-body-statistical">
                    <div class="">
                        <ul class="statistical-list">
                            <?php $testimonials_value = get_field('testimonials_value', 2);
                            if ($testimonials_value):
                            foreach($testimonials_value as $tes):
                            ?>
                            <li class="statistical-item">
                                <?php echo $tes['percent'] ?> <span> - <?php echo $tes['text'] ?></span>
                            </li>
                            <?php endforeach;endif; ?>
                        </ul>
                    </div>
                    <?php $testimonials_comment = get_field('testimonials_comment', 2); ?>
                    <div class="statistical-img">
                        <img src="<?php echo $testimonials_comment['image']['url'] ?>" alt="<?php echo $testimonials_comment['image']['alt'] ?>">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <div class="section-9-author">
                    <h4 class="section-9-author-heading">
                        <?php echo $testimonials_comment['title']; ?>
                    </h4>
                    <div class="section-9-author-body">
                        <i class='bx bx-check-double'></i>
                        <p>
                            <?php echo $testimonials_comment['content']; ?>
                        </p>
                    </div>
                    <div class="section-9-author-name">
                        <?php echo $testimonials_comment['name']; ?>
                        <span><?php echo $testimonials_comment['position']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>