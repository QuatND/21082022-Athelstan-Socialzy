<section id="header-main" class="bg-white">
    <div class="container electro-navbar">
        <div class="row electro-navbar-inner">
            <div class="logo-main col-xl-2 col-lg-2">
                <a href="<?php echo home_url() ?>">
                    <img src="<?php echo get_field('logo_header','option')['url'] ?>"
                        alt="<?php echo get_field('logo_header','option')['alt'] ?>">
                </a>
            </div>
            <div class="col-xl-6 col-lg-6 align-seft">
                <form action="<?php bloginfo('url');?>" class="navbar-form" method="get" accept-charset="utf-8">
                    <div class="select-search-field">
                        <select name="term" class="resizeselect color-2 font-m">
                            <option value="0">Tất cả danh mục</option>
                            <?php
                                $args = array(
                                    'type'      => 'product',
                                    'child_of'  => 0,
                                    'post_type'=>'public',
                                    'hide_empty' => false, 
                                    'parent'    => '0',
                                );
                                $product_terms = get_terms('product_cat', $args );
                                foreach ($product_terms AS $term) :
                                    echo "<option value='".$term->slug."'".($_GET['publication_categories'] == $term->slug ? ' selected="selected"' : '').">".$term->name."</option>\n";
                                endforeach;
                                ?>
                        </select>
                    </div>
                    <div class="input-search-field">
                        <input class="color-input" type="text" name="s" id="search"
                            placeholder="Nhập từ khoá để tìm kiếm">
                    </div>
                    <div class="input-group-btn">
                        <input type="hidden" name="post_type" value="product">
                        <input type="hidden" name="taxonomy" value="product_cat">
                        <button type="submit" class="btn-button bg-main"><i class="fa fa-search"></i>Tìm kiếm</button>
                    </div>
                </form>
            </div>
            <div class="col-xl-4 col-lg-4 align-seft">
                <div class="header-icons">
                    <div class="header-icon d-flex" title="Hotline">
                        <?php $hotline=get_field('hotline','option'); ?>
                        <img src="<?php echo $hotline['icon'] ?>" alt="hotline">
                        <p class="color-input"><?php echo $hotline['title'] ?></p>
                    </div>
                    <div class="header-icon d-flex" title="Đăng nhập / Đăng ký">
                        <?php $login_register=get_field('login_register','option'); ?>
                        <img src="<?php echo $login_register['icon'] ?>" alt="login">
                        <p class="color-input"><?php echo $login_register['title'] ?></p>
                    </div>
                    <div class="header-icon header-icon-cart d-flex" title="Giỏ hàng" id="header-icon-cart">
                        <a href="<?php echo wc_get_cart_url(); ?>">
                            <img src="<?php echo get_field('icon_cart','option') ?>" alt="cart">
                            <?php global $woocommerce;
                                $count = (count(WC()->cart->get_cart()));
                            ?>
                            <span class="cart-items-count"><?php echo $count; ?></span>
                        </a>
                    </div>
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
    <div class="bg-main">
        <div class="container">
            <div class="electro-navbar-inner row">
                <div class="col-3 pading-0">
                    <div class="departments-menu">
                        <a href="#" class="show-dropdown-menu font-m">
                            <span>
                                <i class="fa fa-bars"></i>
                                <?php echo "DANH MỤC SẢN PHẨM";//get_field('thanh_bar','option') ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu-category">
                            <?php
                            $args = array(
                                'type'      => 'product',
                                'child_of'  => 0,
                                'post_type'=>'public',
                                'hide_empty' => false, 
                                'parent'    => '0',
                            );
                            $categories = get_terms( 'product_cat',$args );
                            foreach ( $categories as $key => $category ) { ?>
                            <li>
                                <a href="<?php echo get_term_link($category ) ?>"
                                    <?php if($category->count>0){echo "class='parent'";} ?>><?php echo $category->name ; ?></a>
                                <ul class="sub-list-cate">
                                    <?php
                                        $parent_id=$category->term_id;
                                        $arg = array(
                                            'type'      => 'product',
                                            'child_of'  => 0,
                                            'post_type'=>'public',
                                            'hide_empty' => false, 
                                            'parent'    => $parent_id,
                                            'orderby'=>'name',
                                            'order'=>'ASC',
                                        );
                                        $categories_chill = get_terms( 'product_cat',$arg );
                                        foreach ($categories_chill as $child){
                                            ?>
                                    <a href="<?php echo get_term_link( $child ) ?>">
                                        <li><?php echo $child->name."<br>" ; ?> </li>
                                    </a>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-9 pading-0">
                    <div class="menu-active ">
                        <?php wp_nav_menu(array('menu_main'=>'menu name')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>