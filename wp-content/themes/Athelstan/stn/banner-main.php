<section id="banner-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 pading-0">
            </div>
            <div class="col-lg-9 col-md-12 pading-0">
                <div id="myCarouselBackground" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner owl-carousel owl-theme">
                        <?php
							$banner_carousel=get_field('banner_carousel');
								if($banner_carousel){
									foreach ($banner_carousel as $key => $banner) {
										?>
                        <div class="carousel-item item <?php if($key==0){echo "active";} ?>">
                            <div class="image">
                                <img src="<?php echo $banner['image']['url'] ?>"
                                    alt="<?php echo $banner['image']['alt'] ?>">
                            </div>
                        </div>
                        <?php
									}
								}
							?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>