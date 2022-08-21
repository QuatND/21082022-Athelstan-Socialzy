<section id="header-main">
    <div class="container">
        <div class="row">
            <div class="logo-main col-xl-2 col-lg-2">
                <a href="<?php echo home_url() ?>">
                    <img width="100" height="100" src="<?php echo get_field('header_logo','option')['url'] ?>"
                    alt="<?php echo get_field('header_logo','option')['alt'] ?>">
                </a>
            </div>
            <div class="menu-active col-xl-7 col-lg-7 align-seft">
            <?php wp_nav_menu(['theme_location' => 'menu_main',]); ?>
            </div>
            <div class="col-xl-3 col-lg-3 align-seft">
                <div class="menu-contact">
                    <i aria-hidden="true" class="menu-contact-icon fa fa-phone"></i>
                    <div class="menu-contact-phone">(+021) 1580 3685</div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-bar">
        <div class="open-menu" id="open-menu">
            <i class="fa fa-bars"></i>
        </div>
        <div class="close-menu" id="close-menu">
            <i class="fa fa-times"></i>
        </div>
    </div>
</section>