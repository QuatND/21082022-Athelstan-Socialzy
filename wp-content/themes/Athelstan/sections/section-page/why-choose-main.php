<section id="why-choose-us">
    <!-- Provide -->
    <div class="provide">
        <div class="provide__box row">
            <div class="provide__box--desc col-lg-6 col-md-12 col-12">
                <div class="provide__box--desc--overlay"></div>
                <div class="container">
                    <div class="provide__box--desc--heading">
                        <h4 class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInLeft"><?php echo get_field('why_title_top', 'option') ?></h4>
                        <h4 class="section-1-des-body-heading text-white">
                            <?php echo get_field('why_title', 'option') ?>
                        </h4>
                        <p class="text">
                            <?php echo get_field('why_excerpt', 'option') ?>  
                        </p>
                    </div>
                    <ul class="provide__box--desc--list row">
                    <?php $the_whys = get_field('the_whys', 'option');
                        if ($the_whys) :
                        foreach ($the_whys as $value) :
                        ?>
                        <li class="provide__box--desc--list--item col-lg-6 col-md-6 col-12">
                            <div class="">
                                <?php echo $value['icon'] ?>  
                                <div class="heading"><?php echo $value['title'] ?> </div>
                                <div class="text">
                                    <?php echo $value['content'] ?> 
                                </div>
                            </div>
                        </li>
                        <?php endforeach;
                         endif; ?>
                    </ul>
                </div>
            </div>
            <div class="provide__box--img col-lg-6 col-md-12 col-12" style="background-image: url('<?php echo get_field('why_image', 'option')['url'] ?>')">
                <div class="provide__box--img--child"></div>
            </div>
        </div>
    </div>
</section>