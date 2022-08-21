<?php

/**
 * Template Name: Giới thiệu
 */
get_header();
get_template_part('sections/header-main');
get_template_part('sections/breadcrumb');
get_template_part('sections/experiences-main');
?>
<section id="vision">
    <!-- Mission -->
    <div class="mission">
        <div class="container mission__child">
            <div class="row">
                <?php $the_vision = get_field('the_vision', get_the_id());
                if ($the_vision) :
                    foreach ($the_vision as $value) :
                ?>
                        <div class="col-lg-3 col-md-6 col-12 mission__item--wrap">
                            <div class="mission__item">
                                <div class="mission__item--content">
                                    <?php echo $value['icon'] ?>
                                    <h4 class="heading"><?php echo $value['title'] ?></h4>
                                    <p class="text">
                                        <?php echo $value['content'] ?>
                                    </p>
                                </div>
                                <div class="mission__item--overlay">
                                    <?php echo $value['icon'] ?>
                                </div>
                            </div>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>
<?php
get_template_part('sections/section-page/why-choose-main');
get_template_part('sections/section-page/process-main');
get_template_part('sections/section-page/need-advice-main');
get_template_part('sections/section-page/team-main');
get_footer();
?>