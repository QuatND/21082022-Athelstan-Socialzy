<section id="service-main" class="section-4">
    <div class="container section-4-child">
        <div class="section-4-header">
            <span class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInUp"><?php echo get_field('service_title_top', 2); ?></span>
            <div class="section-1-des-body">
                <div class="section-1-des-body-heading">
                    <?php echo get_field('service_title', 2); ?>
                </div>
                <p class="section-1-des-body-text">
                    <?php echo get_field('service_excerpt', 2); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 section-4-content-wrap wow animate__animated animate__slow animate__fadeInLeft">
                <div class="section-4-content section-4-content-img-wrap">
                    <img src="<?php echo get_field('service_image', 2)['url']; ?>" alt="<?php echo get_field('service_image', 2)['alt']; ?>" class="section-4-content-img">
                </div>
            </div>
            <?php $the_service = get_field('the_service', 2);
            if ($the_service):
            foreach($the_service as $key => $ser):
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12 section-4-content-wrap wow animate__animated animate__slow <?php echo $key < 2 ? 'animate__fadeInLeft' : 'animate__fadeInRight' ?>">
                <div class="section-4-content <?php echo (count($the_service) - 1) === $key ? 'Social-Media-Management' : '' ?>">
                    <div class="section-4-content-icon">
                        <img src="<?php echo $ser['icon']['url'] ?>" alt="<?php echo $ser['icon']['alt'] ?>">
                    </div>
                    <div class="section-4-content-heading">
                        <h5><?php echo $ser['title'] ?></h5>
                    </div>
                    <p class="section-4-content-text">
                        <?php echo $ser['content'] ?>
                    </p>
                    <a href="<?php echo $ser['link'] ?>" class="read-more">
                        <?php echo $ser['text_link'] ?>
                        <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
            </div>
            <?php endforeach;endif; ?>
        </div>
    </div>
</section>