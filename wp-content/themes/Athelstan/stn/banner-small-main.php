<section id="banner-small-main">
    <div class="container">
        <div class="row">
            <?php $banner_small=get_field('the_banner_small',get_the_id());
            if($banner_small):
                foreach ($banner_small as $small) :
            ?>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="item">
                    <div class="image">
                        <img src="<?php echo $small['image']['url'] ?>" alt="<?php echo $small['image']['alt'] ?>">
                    </div>
                    <div class="infor">
                        <p class="title fs-30 text-white font-m"><?php echo $small['title'] ?></p>
                        <p class="title-b text-white font-m"><?php echo $small['title_b'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach;endif; ?>
        </div>
    </div>
</section>