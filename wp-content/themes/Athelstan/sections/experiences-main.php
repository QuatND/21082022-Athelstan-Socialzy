<section id="experiences" class="section-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 section-3-item">
                <div class="section-3-advertisement">
                    <img src="<?php echo get_field('experiences_image_main', 2)['url'] ?>" alt="<?php echo get_field('experiences_image_main', 2)['alt'] ?>" class="section-2-people" />
                    <div class="section-1-banner-statistical section-2-engagement wow animate__animated animate__slow animate__fadeInLeft">
                        <div class="section-1-banner-statistical-icon">
                            <?php echo get_field('banner_engagement', 2)['icon'] ?>
                        </div>
                        <div class="section-1-banner-statistical-number">
                            <?php echo get_field('banner_engagement', 2)['number'] ?>
                            <span><?php echo get_field('banner_engagement', 2)['text'] ?></span>
                        </div>
                    </div>
                    <div class="section-1-banner-statistical section-2-sales-growth wow animate__animated animate__slow animate__fadeInRight">
                        <div class="section-1-banner-statistical-icon">
                            <?php echo get_field('banner_sales_growth', 2)['icon'] ?>
                        </div>
                        <div class="section-1-banner-statistical-number">
                            <?php echo get_field('banner_sales_growth', 2)['number'] ?>
                            <span><?php echo get_field('banner_sales_growth', 2)['text'] ?></span>
                        </div>
                    </div>
                    <img src="<?php echo get_field('experiences_image_children', 2)['url'] ?>" class="section-2-economic-map wow animate__animated animate__slow animate__fadeInDown" alt="<?php echo get_field('experiences_image_children', 2)['alt'] ?>" />
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 section-3-item">
                <div class="section-3-des">
                    <span class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInRight"><?php echo get_field('experiences_title_top', 2) ?></span>
                    <div class="section-1-des-body">
                        <div class="section-1-des-body-heading">
                            <?php echo get_field('experiences_title', 2) ?>
                        </div>
                        <p class="section-1-des-body-text">
                            <?php echo get_field('eexperiences_excerpt', 2) ?>
                        </p>
                    </div>
                    <ul class="section-3-des-list">
                        <?php $the_experiences = get_field('the_experiences', 2);
                        if ($the_experiences):
                        foreach($the_experiences as $key => $ex):
                        ?>
                        <li class="section-3-des-item <?php echo $key === 1 ? 'active' : ''; ?>">
                            <div class="section-3-item-icon-wrap">
                                <div class="section-3-item-icon">
                                    <i class='bx bx-check'></i>
                                </div>
                            </div>
                            <div class="section-3-des-item-content">
                                <h4 class="section-3-des-item-heading"><?php echo $ex['title'] ?></h4>
                                <div class="section-3-des-item-text"><?php echo $ex['text'] ?></div>
                            </div>
                        </li>
                        <?php endforeach;endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>