<section id="trademark-main">
    <div class="container">
        <div class="pro-header row">
            <p class="title fs-28 bg-main text-white font-m"><?php echo get_field('title_trademark',get_the_id()) ?> </p>
        </div>
        <div class="owl-trademark owl-theme owl-carousel row">
            <?php $the_trademark=get_field('the_trademark',get_the_id());
            if($the_trademark):
                foreach ($the_trademark as $key => $trademark) :
            ?>
            <div class="item">
                <img src="<?php echo $trademark['image']['url'] ?>" alt="<?php echo $trademark['image']['alt'] ?>">
            </div>
            <?php endforeach;endif; ?>
        </div>
    </div>
</section>