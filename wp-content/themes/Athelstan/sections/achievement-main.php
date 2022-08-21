<section id="achievement-main" class="section-7">
    <div class="container">
        <div class="row section-7-item-wrap">
            <div class="col-lg-6 col-md-12 col-sm-12 section-7-item-left">
                <span class="section-1-des-welcome wow animate__animated animate__bounce animate__slow animate__fadeInLeft"><?php echo get_field('achievement_title_top', 2) ?></span>
                <div class="section-1-des-body">
                    <div class="section-1-des-body-heading">
                        <?php echo get_field('achievement_title', 2) ?>
                    </div>
                    <p class="section-1-des-body-text">
                        <?php echo get_field('achievement_excerpt', 2) ?>
                    </p>
                    <div class="section-1-des-body-btn">
                        <a href="<?php echo get_field('achievement_link_button', 2) ?>" class="btn btn-custom not-flex">
                            <?php echo get_field('achievement_text_button', 2) ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 section-7-item-right">
                <div class='section-7-item-right-number row'>
                    <?php $the_achievement = get_field('the_achievement', 2);
                    if($the_achievement):
                    foreach($the_achievement as $achievement):
                    ?>
                    <div class="col-lg-6 col-md-6 col-6 section-7-item-right-number-assess-wrap">
                        <div id="statistic" class="section-7-item-right-number-assess">
                            <?php echo $achievement['icon'] ?>
                            <div class="assess-number">
                                <span class="statistic-number"><?php echo $achievement['number'] ?></span><span>+</span>
                            </div>
                            <span class="assess-name"> <?php echo $achievement['text'] ?></span>
                        </div>
                    </div>
                    <?php endforeach;endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>