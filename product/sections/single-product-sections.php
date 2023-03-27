<?php
    global $product;

    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'full' );
    $publisherIDs = get_field('book_publishers', $product->get_id());
    $series = get_the_terms( $product->get_id(), 'series' );
    $epiloges = get_the_terms( $product->get_id(), 'epiloges' );
    $publishersTaxonomy = get_the_terms( $product->get_id(), 'ekdotes' );

    $productGalleryIds = $product->get_gallery_image_ids();
    $productTags = get_the_terms( $product->get_id(), 'product_tag' );
?>
<section class="single-product-section">
    <div class="general-container">
        <div class="content-container">
            <div class="single-product-row">
                <div class="single-product-left-col">
                    <?php
                        if( empty($productGalleryIds) ){
                    ?>
                            <div class="single-product-image">
                                <img
                                    class="lazyload"
                                    src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                    data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                    alt="<?php echo $product->get_name(); ?>">
                            </div>
                    <?php
                        } else {
                    ?>
                            <div class="single-product-gallery-slider" is="mieteshop-product-gallery-slider">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img
                                                class="lazyload"
                                                src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                                data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                                alt="<?php echo $product->get_name(); ?>">
                                        </div>
                                        <?php
                                            foreach($productGalleryIds as $galleryId){
                                                $galleryImage = wp_get_attachment_image_src( $galleryId, 'full' );
                                        ?>
                                                <div class="swiper-slide">
                                                    <img
                                                        class="lazyload"
                                                        src="<?php echo placeholderImage($galleryImage[1], $galleryImage[2]); ?>"
                                                        data-src="<?php echo aq_resize($galleryImage[0], $galleryImage[1], $galleryImage[2], true); ?>"
                                                        alt="<?php echo $product->get_name(); ?>">
                                                </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="single-product-gallery-slider__pagination"></div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="single-product-right-col">
                    <div class="single-product-info">
                        <div class="single-product-tag-row">
                            <?php 
                                if( $series ){
                                    foreach ( $series as $series_term ){
                            ?>
                                        <div class="single-product-tag"><a href="<?php echo get_term_link($series_term->term_id); ?>"><?php echo $series_term->name; ?></a></div>
                            <?php
                                    }        
                                }
                            
                            if( $publishersTaxonomy ) {
                                foreach ( $publishersTaxonomy as $publisher_term ){
                            ?>
                                <div class="single-product-tag"><a href="<?php echo get_term_link($publisher_term->term_id); ?>"><?php echo $publisher_term->name; ?></a></div>
                            <?php
                                }
                            }

                            
                                //if( $publisherIDs ){
                                //    foreach($publisherIDs as $publisherID){
                            ?>
                                    <!--<div class="single-product-tag"><a href="<?php //echo get_permalink($publisherID); ?>"><?php //echo get_the_title($publisherID); ?></a></div>-->
                            <?php
                                //    }	     
                                //}

                                if( $epiloges ){ 
                                    foreach($epiloges as $epilogi) {
                                        if($epilogi->slug == 'nees-kyklofories' || $epilogi->slug == 'nees-kyklofories-miet'){    
                            ?>
                                            <div class="single-product-tag active"><a href="<?php echo get_term_link($epilogi->term_id); ?>"><?php echo $epilogi->name; ?></a></div>
                            <?php
                                        }    
                                    }
                                }

                                if( $productTags ) {
                                    foreach ( $productTags as $tag ){
                                ?>
                                    <div class="single-product-tag active"><a><?php echo $tag->name; ?></a></div>
                                <?php
                                    }
                                }                                
                            ?>
                        </div>
                        <div class="single-product-author">
                            <?php
                                $authorIDs = get_field('book_contributors_syggrafeas', $product->get_id());

                                if( $authorIDs ){
                                    if( count($authorIDs) > 3){
                                        echo 'Συλλογικό Έργο';	
                                    } else {					
                                        $authorAA = 1;
                                        foreach($authorIDs as $authorID) {
                            ?>
                                            <a href="<?php echo get_permalink($authorID); ?>"><?php echo get_the_title($authorID); ?></a>
                            <?php
                                            //add a / after each author when authors more than 1 and don't add on last author
                                            if(count($authorIDs) > 1 && count($authorIDs) != $authorAA ) { echo ' / '; } 
                                            $authorAA++;
                                        }	
                                    }	
                                } else {
                                    echo get_field('book_biblionet_writer_name');
                                }
                            ?>
                        </div>
                        <div class="single-product-title">
                            <h1><?php echo get_the_title(); ?></h1>
                        </div>
                        <div class="single-product-subtitle">
                            <h2><?php echo get_field('book_subtitle'); ?></h2>
                        </div>
                        <div class="single-product-role-detail-wrapper">
                            <?php 
                                $contributorFields = acf_get_fields(3523);
                                foreach($contributorFields as $contributorField) {
                                    $contributors = get_field($contributorField['name']);
                                    //echo '<pre>'; var_dump($contributors); echo '</pre>';
                                    if($contributors){
                                        if ($contributorField['name'] != 'book_contributors_syggrafeas') {
                            ?>
                                        <div class="single-product-role-detail">
                                            <div class="single-product-role-detail__role"><?php echo $contributorField['label']; ?></div>
                                            <?php
                                                foreach($contributors as $contributor) {
                                            ?>
                                                    <div class="single-product-role-detail__detail"><a href="<?php echo get_permalink($contributor->ID); ?>"><?php echo $contributor->post_title; ?></a></div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                            <?php
                                        }
                                    }                    
                                }
                            ?>
                        </div>
                        <?php if(get_field('book_comments')) { ?>
                        <div class="single-product-comments">
                            <?php echo get_field('book_comments'); ?>
                        </div>   
                        <?php } ?>
                        <div class="single-product-info-table-1-row">
                            <div class="single-product-form-col"><span>ΜΟΡΦΗ</span></div>
                            <div class="single-product-form-value"><span><?php echo get_field('book_cover_type'); ?></span></div>
                            <div class="single-product-price-col"><span>ΤΙΜΗ</span></div>
                            <?php 
                                $regular_price = (float) get_post_meta( get_the_ID(), '_regular_price', true);
                                $woo_sale_price = (float) get_post_meta( get_the_ID(), '_sale_price', true);
                                $price_symbol = get_woocommerce_currency_symbol(get_option('woocommerce_currency'));
                                $availability = $product->get_availability();
                                $stock_status = isset( $availability['class'] ) ? $availability['class'] : false;


                                //Since rules are applied during runtime, we need to use filters to get woo discount rules discount price - if any - 
                                ///$discounted_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price', false, $product, 1, 0, 'all', true);
                                $discounted_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price', $product->get_price(), $product, 1, 0, 'discounted_price', true);
                                //$wooco_discounted_price = $product->get_sale_price();
                                if ($discounted_price !== false) {
                                     //if ($discounted_price['discounted_price']  > 0) { //woo discount rule
                                    $sale_price = $discounted_price;
                                } else { 
                                    $sale_price = $woo_sale_price; //woo discount rules returns false so get woocommerce sale_price 
                                }                               

                                if($sale_price > 0) {
                            ?>
                                    <div class="single-product-regular-price"><span><?php echo number_format($regular_price, 2, ',', ''); ?><?php echo  $price_symbol; ?></span></div>
                                    <div class="single-product-sale-price"><span><?php echo number_format($sale_price, 2, ',', ''); ?><?php echo  $price_symbol; ?></span></div>
                            <?php
                                } elseif($regular_price > 0) {
                            ?>
                                    <div class="single-product-regular-price"></div>
                                    <div class="single-product-sale-price"><span><?php echo number_format($regular_price, 2, ',', ''); ?><?php echo  $price_symbol; ?></span></div>
                            <?php
                                } else { 
                            ?>        
                                    <div class="single-product-regular-price"></div>
                                    <div class="single-product-sale-price"></div>
                            <?php             
                                }

                            ?>
                            
                            <?php
                                if($sale_price > 0) {
                                    $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';
                            ?>
                                    <div class="single-product-discount"><span><?php echo $saving_percentage; ?></span></div>
                            <?php
                                } else { ?> <div class="single-product-discount"></div> <?php }
                            ?>
                            <div class="single-product-availability">
                                <span>
                                    <?php                                         
                                        //echo $availability['availability'] .' - ' .$availability['class'] .'<br/>';
                                        if ($stock_status == 'out-of-stock') { echo 'εξαντλημένο'; } else { echo 'άμεσα διαθέσιμο'; } 
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="single-product-info-table-2-row">
                            <div class="single-product-share-col">
                                <div class="single-product-share-icon a2a_dd"><?php include get_template_directory() . '/assets/icons/share-icon.svg' ?>
                                    <script>
                                        var a2a_config = a2a_config || {};
                                        a2a_config.color_bg = "dedbd4";
                                        a2a_config.color_main = "D7E5ED";
                                        a2a_config.color_border = "1f1f1f";
                                        a2a_config.color_link_text = "000000";
                                        a2a_config.color_link_text_hover = "000000";
                                        a2a_config.icon_color = "000000";
                                        a2a_config.icon_color = "black";
                                    </script>
                                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                                </div>
                            </div>
                            <div class="single-product-favorite-col">
                                <div class="single-product-favorite-button">
                                    <div class="single-product-favorite-button__icon"><?php echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $product->get_id() . '" is_single="yes"]'); ?></div>
                                    <div class="single-product-favorite-button__label">Προσθήκη στα αγαπημένα</div>
                                </div>
                            </div>
                            <div class="single-product-add-tocart-col">
                                <!--a href="#">Προσθήκη στο καλάθι</a-->
                                <?php if( ($sale_price > 0 || $regular_price > 0) && $stock_status != 'out-of-stock') { ?>
                                    <a class="js-mieteshop-add-to-cart" href="#" data-quantity="1" data-product_id="<?php echo $product->get_id(); ?>" data-variation_id="0" data-product_sku="<?php echo $product->get_sku(); ?>">Προσθήκη στο καλάθι</a>
                                <?php } else { ?>
                                    <span>Προσθήκη στο καλάθι</span>
                                <?php 
                                }    
                                ?>   
                            </div>
                        </div>
                    </div>
                    <div class="single-product-tab-header-row">
                        <div class="single-product-tab-header-item active" data-section-id="description">ΠΕΡΙΓΡΑΦΗ</div>
                        <div class="single-product-tab-header-item" data-section-id="detail-information">ΑΝΑΛΥΤΙΚΑ ΣΤΟΙΧΕΙΑ</div>
                    </div>
                    <div class="single-product-tab-content-row">
                        <div id="single-product-tab-content-item--description" class="single-product-tab-content-item">
                            <div class="single-product-description"><?php the_content(); ?></div>
                        </div>
                        <div id="single-product-tab-content-item--detail-information" class="single-product-tab-content-item hide">
                            <div class="single-product-detail-information-row">
                                <?php
                                    if( get_field('book_isbn') ){
                                ?>
                                        <div class="single-product-detail-information-item book_isbn">
                                            <div class="single-product-detail-information-item__label">ISBN</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_isbn'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_issn') ){
                                ?>
                                        <div class="single-product-detail-information-item book_issn">
                                            <div class="single-product-detail-information-item__label">ISSN</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_issn'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php if ($product->get_width() && $product->get_height() ) { ?>
                                <div class="single-product-detail-information-item width_height">
                                    <div class="single-product-detail-information-item__label">ΔΙΑΣΤΑΣΕΙΣ</div>
                                    <div class="single-product-detail-information-item__value"><?php echo $product->get_width() .' x ' .$product->get_height(); ?> εκ.</div>
                                </div>
                                <?php } ?>
                                <?php
                                    if( get_field('book_setisbn') ){
                                ?>
                                        <div class="single-product-detail-information-item book_setisbn">
                                            <div class="single-product-detail-information-item__label">ISBN SET</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_setisbn'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_language') ){
                                ?>
                                        <div class="single-product-detail-information-item book_language">
                                            <div class="single-product-detail-information-item__label">ΓΛΩΣΣΑ</div>
                                            <div class="single-product-detail-information-item__value">
                                                <?php
                                                    $booklanguage = get_field('book_language');
                                                    echo $booklanguage['label'];
                                                ?>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_first_published_date') ){
                                ?>
                                        <div class="single-product-detail-information-item book_first_published_date">
                                            <div class="single-product-detail-information-item__label">ΠΡΩΤΗ ΕΚΔΟΣΗ</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_first_published_date'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_original_title') ){
                                ?>
                                        <div class="single-product-detail-information-item book_original_title">
                                            <div class="single-product-detail-information-item__label">ΠΡΩΤΟΤΥΠΟΣ ΤΙΤΛΟΣ</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_original_title'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_current_published_date') ){
                                ?>
                                        <div class="single-product-detail-information-item book_current_published_date">
                                            <div class="single-product-detail-information-item__label">ΤΡΕΧΟΥΣΑ ΕΚΔΟΣΗ</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_current_published_date'); ?>
                                            <?php 
                                                if ( get_field('book_first_published_date_details') ) {
                                                    echo ', ' .get_field('book_first_published_date_details'); 
                                                }    
                                            ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_original_language') && (get_field('book_original_language') != get_field('book_language')) ){
                                ?>
                                        <div class="single-product-detail-information-item book_language">
                                            <div class="single-product-detail-information-item__label">ΓΛΩΣΣΑ ΠΡΩΤΟΤΥΠΟΥ</div>
                                            <div class="single-product-detail-information-item__value">
                                                <?php $booklanguageOrig = get_field('book_original_language'); echo $booklanguageOrig['label']; ?>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php 
                                    if( $publisherIDs ){
                                ?>
                                        <div class="single-product-detail-information-item publishers">
                                            <div class="single-product-detail-information-item__label">ΕΚΔΟΤΗΣ</div>
                                            <div class="single-product-detail-information-item__value">
                                                <?php 
                                                if( $publishersTaxonomy ) {
                                                    foreach ( $publishersTaxonomy as $publisher_term ){
                                                ?>
                                                    <a href="<?php echo get_term_link($publisher_term->term_id); ?>"><?php echo $publisher_term->name; ?></a><br/>
                                                <?php
                                                    }
                                                }

                                                    //foreach($publisherIDs as $publisherID) {
                                                ?>
                                                    <!--<a href="<?php //echo get_permalink($publisherID); ?>"><?php //echo get_the_title($publisherID); ?></a>-->
                                                <?php
                                                    //}	                                    
                                                ?>
                                            </div>
                                        </div>
                                <?php
                                    }   
                                ?>
                                <?php
                                    //if( $product->get_weight() ){
                                ?>
                                        <!--div class="single-product-detail-information-item weight">
                                            <div class="single-product-detail-information-item__label">ΒΑΡΟΣ</div>
                                            <div class="single-product-detail-information-item__value"><?php //echo $product->get_weight(); ?> γρ.</div>
                                        </div-->
                                <?php
                                    //}
                                ?>
                                <?php 
                                    if( $series ){
                                ?>                
                                        <div class="single-product-detail-information-item series">
                                            <div class="single-product-detail-information-item__label">ΣΕΙΡΑ</div>
                                            <div class="single-product-detail-information-item__value">
                                                <?php 
                                                    foreach ( $series as $series_term ) {
                                                ?>
                                                        <div><?php echo $series_term->name; ?></div>
                                                <?php
                                                    }            
                                                ?>                    
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_miet_code') ){
                                ?>
                                        <div class="single-product-detail-information-item book_miet_code">
                                            <div class="single-product-detail-information-item__label">ΚΩΔΙΚΟΣ ΜΙΕΤ</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_miet_code'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_page_number') ){
                                ?>
                                        <div class="single-product-detail-information-item book_page_number">
                                            <div class="single-product-detail-information-item__label">ΑΡΙΘΜΟΣ ΣΕΛΙΔΩΝ</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_page_number'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_multivolume_title') ){
                                ?>
                                        <div class="single-product-detail-information-item book_multivolume_title">
                                            <div class="single-product-detail-information-item__label">ΤΙΤΛΟΣ ΤΟΜΩΝ</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_multivolume_title'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>                                
                                <?php
                                    if( get_field('book_eudoxus_code') ){
                                ?>
                                        <div class="single-product-detail-information-item book_eudoxus_code">
                                            <div class="single-product-detail-information-item__label">ΚΩΔΙΚΟΣ ΣΤΟΝ ΕΥΔΟΞΟ</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_eudoxus_code'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if( get_field('book_number_of_images') ){
                                ?>
                                        <div class="single-product-detail-information-item book_number_of_images">
                                            <div class="single-product-detail-information-item__label">ΕΙΚΟΝΕΣ</div>
                                            <div class="single-product-detail-information-item__value"><?php echo get_field('book_number_of_images'); ?></div>
                                        </div>
                                <?php
                                    }
                                ?>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>