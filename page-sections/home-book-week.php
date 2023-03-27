<?php if(get_field('book_of_the_week')) { ?>
<section class="home-book-week-section">
    <div class="small-container">
        <div class="home-book-week-title">
            <h2>ΤΟ ΒΙΒΛΙΟ ΤΗΣ ΕΒΔΟΜΑΔΑΣ</h2>
        </div>
        <?php
            $weekbook = get_field('book_of_the_week');
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $weekbook->ID ), 'full' );
            $authorIDs = get_field('book_contributors_syggrafeas', $weekbook->ID);
            $weekbook_product = wc_get_product( $weekbook->ID );
        ?>
        <div class="home-book-week-row">
            <div class="home-book-week-left">
                <a href="<?php echo get_permalink($weekbook->ID); ?>">
                <img
                    class="lazyload"
                    src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                    data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                    alt="<?php echo $weekbook->post_title; ?>">
                </a>    
            </div>
            <div class="home-book-week-right">
                <?php
                    if( !empty($authorIDs) ){
                        echo '<div class="home-book-week-author-list">';
                        if( count($authorIDs) > 3 ){
                            echo '<div class="home-book-week-author-item">Συλλογικό Έργο</div>';
                        } else {
                            foreach( $authorIDs as $authorID ){
                                echo '<div class="home-book-week-author-item"><a href="'. get_permalink($authorID) . '">' . get_the_title($authorID) . '</a></div>';
                            }
                        }
                        echo '</div>';
                    }
                ?>
                <div class="home-book-week-product-title">
                    <h3><a href="<?php echo get_permalink($weekbook->ID); ?>"><?php echo $weekbook->post_title; ?></a></h3>
                </div>
                <div class="home-book-week-product-content">
                    <p><?php echo mb_substr(strip_tags($weekbook->post_content), 0, 600, 'UTF-8'); ?> »</p>
                </div>
                <div class="home-book-week-product-meta-row">
                    <div class="home-book-week-product-meta-col">
                        <div class="home-book-week-product-price">

                        <?php 
                        /*
                            $regular_price = get_post_meta( $weekbook->ID, '_regular_price', true);
                            $sale_price = get_post_meta( $weekbook->ID, '_sale_price', true);
                            if($sale_price) {
                                echo $regular_price;
                                echo $sale_price;
                            } else {
    	                        echo $weekbook_product->get_regular_price();
                            }

                            if($sale_price) {
                                $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';
                        */        
                        ?>
                                <!--div class="single-product-discount"><span><?php //echo $saving_percentage; ?></span></div-->
                        <?php
                            //}
                        ?>

                        
                            <?php echo $weekbook_product->get_price_html(); ?>
                        </div>
                    </div>
                    <!--div class="home-book-week-product-meta-col">
                        <div class="home-book-week-product-discount">-30%</div>
                    </div-->
                    <div class="home-book-week-product-meta-col">
                        <div class="home-book-week-product-favorite">
                            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $weekbook->ID . '"]'); ?>
                        </div>
                    </div>
                    <div class="home-book-week-product-meta-col">
                        <!--div class="home-book-week-product-busket">
                            <a href="#"><span><?php include get_template_directory() . '/assets/icons/busket-small-icon.svg' ?></span></a>
                        </div-->
                        <?php
                            if( !$weekbook_product->is_purchasable() ||  !$weekbook_product->is_in_stock() ){
                                if( !$weekbook_product->is_purchasable() ){
                                    echo '<span style="color:red">Μη διαθέσιμο</span>';
                                } elseif ( !$weekbook_product->is_in_stock() ) {
                                    echo '<span style="color:red">Εξαντλημένο</span>';
                                }
                            } else {
                        ?>
                                <div class="pcat-result-item-busket">
                                    <a class="js-mieteshop-add-to-cart" href="#" data-quantity="1" data-product_id="<?php echo $weekbook_product->get_id(); ?>" data-variation_id="0" data-product_sku="<?php echo $weekbook_product->get_sku(); ?>"><span><?php include get_template_directory() . '/assets/icons/busket-small-icon.svg' ?></span></a>
                                </div>
                        <?php
                            }
                        ?>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>