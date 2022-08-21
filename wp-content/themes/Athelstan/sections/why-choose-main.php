<section id="why-choose-main" class="section-2">
    <div class="container">
        <div class="row section-2-item-wrap">
            <div class="col-lg-3 col-md-6 col-sm-12 section-2-item-wrap-child">
                <div class="section-2-item">
                    <div class="section-2-item-heading"><?php echo get_field('why_title', get_the_id()) ?></div>
                    <div class="section-2-item-body">
                        <?php echo get_field('why_excerpt', get_the_id()) ?>
                    </div>
                </div>
            </div>
            <?php $why_excerpt = get_field('why_the_excerpt', get_the_id());
            if (count($why_excerpt) > 0) :
            foreach($why_excerpt as $key => $exc):
            ?>
            <div class="col-lg-3 col-md-6 col-sm-12 section-2-item-wrap-child">
                <div class="section-2-item section-2-item-noIcon <?php echo $key == 0 ? 'border-custom' : '' ?><?php echo $key == 1 ? ' active' : '' ?>">
                    <?php echo $exc['icon'] ?>
                    <div class="section-2-item-heading"><?php echo $exc['title'] ?></div>
                    <div class="section-2-item-body">
                        <?php echo $exc['content'] ?>
                    </div>
                </div>
            </div>
            <?php endforeach;endif; ?>
        </div>
    </div>
</section>