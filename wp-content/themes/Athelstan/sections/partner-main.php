<section id="partner-main" class="section-8">
    <div class="container">
        <div class="section-8-trademark">
            <div class="section-8-trademark-list owl-theme owl-carousel">
                <?php $the_partner = get_field('the_partner', 2);
                if ($the_partner):
                foreach($the_partner as $partner):
                ?>
                <div class="section-8-trademark-item item">
                    <img src="<?php echo $partner['image']['url'] ?>" alt="<?php echo $partner['image']['alt'] ?>">
                </div>
                <?php endforeach;endif; ?>
            </div>
        </div>
    </div>
</section>