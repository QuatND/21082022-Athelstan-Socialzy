<section id="pricing-main" class="section-5">
    <div class="container">
        <div class="section-5-header">
            <span class="section-1-des-welcome wow animate__animated animate__slow animate__fadeInUp"><?php echo get_field('pricing_title_top', 2) ?></span>
            <div class="section-1-des-body">
                <div class="section-1-des-body-heading">
                    <?php echo get_field('pricing_title', 2) ?>
                </div>
                <p class="section-1-des-body-text">
                    <?php echo get_field('pricing_excerpt', 2) ?>
                </p>
            </div>
        </div>
        <div class="row section-5-plan-info wow animate__animated animate__slow animate__fadeInUp">
            <?php $the_pricing = get_field('the_pricing', 2);
            if ($the_pricing):
            foreach($the_pricing as $key => $price):
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12 section-5-plan-info-item <?php echo $key == 1 ? 'active' : '' ?>">
                <div class="section-5-plan-icon">
                    <?php echo $price['icon'] ?>
                </div>
                <div class="section-5-plan-name">
                    <?php echo $price['title'] ?>
                </div>
                <div class="section-5-plan-price">
                    <?php echo $price['price'] ?>
                    <span> <?php echo $price['text_price'] ?></span>
                </div>
                <a href=" <?php echo $price['link_button'] ?>" class="btn btn-custom">
                    <?php echo $price['text_button'] ?>
                    <i class="bx bx-right-arrow-circle"></i>
                </a>
                <ul class="section-5-plan-list">
                    <?php $lists = $price['the_info'];
                    if ($lists):
                    foreach($lists as $list):
                    ?>
                    <li class="section-5-plan-item">
                        <i class='bx bx-check'></i>
                        <?php echo $list['text'] ?>
                    </li>
                    <?php endforeach;endif; ?>
                </ul>
            </div>
            <?php endforeach;endif; ?>
        </div>
    </div>
</section>