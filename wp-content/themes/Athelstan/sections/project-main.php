<section id="project-main" class="section-6">
    <div class="container">
        <div class="section-6-item-hi row">
            <div class="col-lg-6 col-md-12 col-sm-12 section-6-item-left">
                <span class="section-1-des-welcome wow animate__animated animate__bounce animate__slow animate__fadeInLeft"><?php echo get_field('project_title_top', 2) ?></span>
                <div class="section-1-des-body">
                    <div class="section-1-des-body-heading">
                        <?php echo get_field('project_title', 2) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 section-6-item-right">
                <p><?php echo get_field('project_excerpt', 2) ?></p>
                <a href="<?php echo get_field('project_link_button', 2) ?>" class="btn btn-custom not-flex"><?php echo get_field('project_text_button', 2) ?></a>
            </div>
        </div>
    </div>
    <div class="section-6-item-des row wow animate__animated animate__slow animate__fadeInUp">
        <?php $project_images = get_field('project_images', 2);
        if ($project_images) :
        foreach ($project_images as $pro) :
        ?>
                <div class="col-lg-3 col-md-6 col-12 section-6-item-child">
                    <div class="section-6-item-des-img">
                        <img src="<?php echo $pro['image']['url'] ?>" alt="<?php echo $pro['image']['alt'] ?>">
                        <div class="section-6-item-des-img-text">
                            <?php echo $pro['title'] ?>
                            <span><?php echo $pro['content'] ?></span>
                        </div>
                    </div>
                </div>
        <?php endforeach;
        endif; ?>
    </div>
</section>