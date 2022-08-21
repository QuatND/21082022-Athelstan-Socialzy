<section id="product-main"  class="wrapper-product">
    <div class="container">
        <div class="selling-products tab-product">
            <div class="pro-header row">
                <p class="title fs-28 bg-main text-white font-m">SẢN PHẨM BÁN CHẠY </p>
                <ul class="category-list d-flex">
                    <li><a href="">Laptop Dell</a></li>
                    <li><a href="">Laptop ASUS</a></li>
                    <li><a href="">Laptop HP</a></li>
                    <li><a href="">Macbook</a></li>
                    <li><a href="" class="active">Xem tất cả</a></li>
                </ul>
            </div>
            <div id="primary">
                <div class="woocommerce">
                    <ul class="products">
                        <?php 
                        $query_args = array(
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'posts_per_page' => 8,
                            'orderby' => 'ID',
                            'order' => 'DESC',
                        );
                        $my_query = new WP_Query( $query_args );
                        while($my_query->have_posts()) : $my_query->the_post();
                        ?>
                        <li class="product">
                            <a href="">
                            <?php the_post_thumbnail() ?>
                            <h2><?php echo get_the_title(); ?></h2>
                            <div class="price">
                            <?php $product = wc_get_product(get_the_id());
                                echo $product->get_price_html();
                            ?>
                            </div>
                            </a>
                        </li>
                        <?php endwhile; wp_reset_query();?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>