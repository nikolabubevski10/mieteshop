<?php
    // Get recently viewed product cookies data
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

    global $product;

    if( !empty($viewed_products) ){
        // remove current single product id
        $post__in = array_diff($viewed_products, [$product->get_id()]);

        if( !empty($post__in) ){

            $args = [
                'post_type' => 'product',
                'posts_per_page' => 4,
                'fields' => 'ids',
                'post__in' => $post__in
            ];

            $loop = new WP_Query( $args );

            if ( !empty($loop->posts) ) {
?>
                <section class="single-product-recently-section">
                    <div class="content-container">
                        <div class="single-product-recently-title">
                            <h2>ΕΙΔΑΤΕ ΠΡΟΣΦΑΤΑ</h2>
                        </div>
                        <div class="pcat-results-row product-list-desktop-slider">
                            <?php  
                                foreach( $loop->posts as $postid ) {
                            ?>
                                    <div class="pcat-results-col">
                                        <?php get_template_part('product/loop/loop', 'product-card', [ 'postId' => $postid ]); ?>
                                    </div>
                            <?php
                                }
                                wp_reset_query();
                            ?>
                        </div>
                        <div class="product-list-mobile-slider"  is="mieteshop-product-list-mobile-slider">
                            <div class="swiper-container" data-slider>
                                <div class="swiper-wrapper">
                                    <?php  
                                        foreach( $loop->posts as $postid ) {
                                    ?>
                                            <div class="swiper-slide">
                                                <div class="pcat-results-col">
                                                    <?php get_template_part('product/loop/loop', 'product-card', [ 'postId' => $postid ]); ?>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                        wp_reset_query();
                                    ?>
                                </div>
                                <div class="product-list-mobile-slider-nav-wrapper">
                                    <div data-slider-button="prev" class="product-list-mobile-slider-nav product-list-mobile-slider-nav--prev"><?php include get_template_directory() . '/assets/icons/slider-prev-icon.svg'; ?></div>
                                    <div data-slider-button="next" class="product-list-mobile-slider-nav product-list-mobile-slider-nav--next"><?php include get_template_directory() . '/assets/icons/slider-next-icon.svg'; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
<?php
            }           
        }
    }
?>