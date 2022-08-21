<section>
    <div class="needAdvice">
        <div class="needAdvice__overlay" style="background-image: url('<?php echo get_field('need_advice_background', 'option')['url'] ?>')"></div>
        <div class="container">
            <div class="needAdvice__item wow animate__animated animate__slow animate__fadeInUp">
                <div class="needAdvice__item--heading">
                    <h4 class="section-1-des-body-heading text-white">
                        <?php echo get_field('need_advice_title', 'option') ?>
                    </h4>
                </div>
                <div class="needAdvice__item--text">
                    <p class="text">
                    <?php echo get_field('need_advice_excerpt', 'option') ?>
                    </p>
                </div>
                <div class="needAdvice__item--btn">
                    <a href="<?php echo get_field('need_advice_link_button', 'option') ?>" class="btn btn-custom not-flex"><?php echo get_field('need_advice_text_button', 'option') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>