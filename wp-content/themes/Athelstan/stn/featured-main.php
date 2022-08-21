<section id="featured-main">
    <div class="container">
        <div class="featured d-flex bg-white">
            <?php $the_featured=get_field('the_featured',get_the_id()); ?>
            <?php 
            if($the_featured):
                foreach($the_featured as $featured):
            ?>
            <div class="item d-flex">
                <img class="align-seft" src="<?php echo $featured['icon']['url'] ?>" alt="<?php echo $featured['icon']['alt'] ?>">
                <div class="infor">
                    <p class="title color-main"><?php echo $featured['title'] ?></p>
                    <p class="intro color-2"><?php echo $featured['intro'] ?></p>
                </div>
            </div>
            <?php endforeach;endif; ?>
        </div>
    </div>
</section>