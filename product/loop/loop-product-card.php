<?php
    /**
     * Product card of list
     * Template args
     * postID : post ID
     */
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $args['postId'] ), 'full' );
    $authorIDs = get_field('book_contributors_syggrafeas', $args['postId']);
    $post_title = get_the_title($args['postId']);
    $product = wc_get_product( $args['postId'] );
?>
<div class="pcat-result-item">
    <div class="pcat-result-item-info">
        <div class="pcat-result-item-image">
            <a href="<?php echo get_permalink($args['postId']); ?>">
                <img
                    class="lazyload"
                    src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                    data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                    alt="<?php echo $post_title; ?>">
            </a>
        </div>
        <div class="pcat-result-item-meta-row">
            <div class="pcat-result-item-meta-col">
                <div class="pcat-result-item-favorite">
                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $args['postId'] . '"]'); ?>
                </div>
            </div>
            <div class="pcat-result-item-meta-col">
                <?php
                    
                    if( !$product->is_purchasable() ||  !$product->is_in_stock() ){
                        ?>
                        <span><?php include get_template_directory() . '/assets/icons/busket-small-icon.svg' ?></span>
                        <?php
                        //if( !$product->is_purchasable() ){
                        //    echo '<span style="color:red">Μη διαθέσιμο</span>';
                        //} elseif ( !$product->is_in_stock() ) {
                        //    echo '<span style="color:red">Εξαντλημένο</span>';
                        //}
                    } else {                                                            
                ?>
                        <div class="pcat-result-item-busket">
                            <a class="js-mieteshop-add-to-cart" href="#" data-quantity="1" data-product_id="<?php echo $product->get_id(); ?>" data-variation_id="0" data-product_sku="<?php echo $product->get_sku(); ?>"><span><?php include get_template_directory() . '/assets/icons/busket-small-icon.svg' ?></span></a>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>
        <?php
            if( !empty($authorIDs) ){
                echo '<div class="pcat-result-item-author-list">';
                if( count($authorIDs) > 3 ){
                    echo '<div class="pcat-result-item-author-item">Συλλογικό Έργο</div>';
                } else {
                    foreach( $authorIDs as $authorID ){
                        echo '<div class="pcat-result-item-author-item"><a href="'. get_permalink($authorID) . '">' . get_the_title($authorID) . '</a></div>';
                    }
                }
                echo '</div>';
            }
        ?>
        <div class="pcat-result-item-title"><h3><a href="<?php echo get_permalink($args['postId']); ?>"><?php echo $post_title; ?></a></h3></div>
    </div>
    <div class="pcat-result-item-footer-row">
        <div class="pcat-result-item-footer-col">
            <div class="pcat-result-item-footer-product-price">
                <?php echo $product->get_price_html(); ?>
            </div>
        </div>
        <div class="pcat-result-item-footer-col cover-type">
           <div class="pcat-result-item-book-cover-type"><?php echo get_field('book_cover_type', $product->get_id()); ?></div>
        </div>    
    </div>
</div>