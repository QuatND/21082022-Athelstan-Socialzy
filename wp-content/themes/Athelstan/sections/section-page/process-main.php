<section id="process">
    <!-- advice-step -->
    <div class="advice-step">
        <div class="container">
            <div class="advice-step__header">
                <div class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInUp"><?php echo get_field('process_title_top', 'option') ?></div>
                <h4 class="section-1-des-body-heading"><?php echo get_field('process_title', 'option') ?></h4>
                <p class="text">
                    <?php echo get_field('process_content', 'option') ?>
                </p>
            </div>
            <div class="advice-step__item row wow animate__animated animate__slow animate__fadeInUp">
                <?php
                $the_process = get_field('the_process', 'option');
                if ($the_process) :
                    foreach ($the_process as $value) :
                ?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="advice-step__item--number">
                                <div class="advice-step__item--number--icon">
                                    <?php echo $value['icon'] ?>
                                </div>
                                <h4 class="heading"><?php echo $value['title'] ?></h4>
                                <p class="text">
                                    <?php echo $value['content'] ?>
                                </p>
                            </div>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>