<?php if( get_field('homepage_offers_rel') ) { ?>
<section class="book-slider home-offers-section" is="mieteshop-book-slider">
    <div class="book-slider-container">
        <div class="home-offers-title book-slider-title">
            <h2>ΠΡΟΣΦΟΡΕΣ</h2>
        </div>
        <div class="home-offers-row book-slider-wrapper">
            <div class="swiper-container" data-slider>
                <div class="swiper-wrapper">                
                    <?php
                    $homepage_offers_rel = get_field('homepage_offers_rel');

                    foreach($homepage_offers_rel as $offer){
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $offer->ID ), 'full' );
                        $authorIDs = get_field('book_contributors_syggrafeas', $offer->ID);
                        ?>
                        <div class="swiper-slide"><!--div class="home-offers-col"-->
                            <div class="book-slider-item">
                                <div class="home-offers-image book-slider-image">
                                    <a href="<?php echo get_permalink($offer->ID); ?>">
                                    <img
                                    class="lazyload"
                                    src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                    data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                    alt="<?php echo $offer->post_title; ?>">
                                    </a>
                                </div>
                                <div class="home-offers-info">
                                <?php
                                if( !empty($authorIDs) ){
                                    echo '<div class="home-offers-author-list">';
                                    if( count($authorIDs) > 3 ){
                                        echo '<div class="home-offers-author-item">Συλλογικό Έργο</div>';
                                    } else {
                                        foreach( $authorIDs as $authorID ){
                                            echo '<div class="home-offers-author-item"><a href="'. get_permalink($authorID) . '">' . get_the_title($authorID) . '</a></div>';
                                        }
                                    }
                                    echo '</div>';
                                }
                                ?>
                                <div class="home-offers-product-title">
                                    <a href="<?php echo get_permalink($offer->ID); ?>"><h3><?php echo $offer->post_title; ?></h3></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="book-slider-nav-wrapper">
                <div data-slider-button="prev" class="book-slider-nav book-slider-nav--prev"><?php include get_template_directory() . '/assets/icons/slider-prev-white-icon.svg'; ?></div>
                <div data-slider-button="next" class="book-slider-nav book-slider-nav--next"><?php include get_template_directory() . '/assets/icons/slider-next-white-icon.svg'; ?></div>
            </div>            
        </div>
        <div class="home-offers-mobile-slider" is="mieteshop-home-offers-mobile-slider">
            <div class="swiper-container" data-slider>
                <div class="swiper-wrapper">
                    <?php
                        $homepage_offers_rel = get_field('homepage_offers_rel');

                        foreach($homepage_offers_rel as $offer){
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $offer->ID ), 'full' );
                            $authorIDs = get_field('book_contributors_syggrafeas', $offer->ID);
                    ?>
                            <div class="swiper-slide">
                                <div class="home-offers-col">
                                    <div class="book-slider-image">
                                        <a href="<?php echo get_permalink($offer->ID); ?>">
                                            <img
                                                class="lazyload"
                                                src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                                data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                                alt="<?php echo $offer->post_title; ?>">
                                        </a>
                                    </div>
                                    <div class="home-offers-info">
                                        <?php
                                            if( !empty($authorIDs) ){
                                                echo '<div class="home-offers-author-list">';
                                                if( count($authorIDs) > 3 ){
                                                    echo '<div class="home-offers-author-item">Συλλογικό Έργο</div>';
                                                } else {
                                                    foreach( $authorIDs as $authorID ){
                                                        echo '<div class="home-offers-author-item"><a href="'. get_permalink($authorID) . '">' . get_the_title($authorID) . '</a></div>';
                                                    }
                                                }
                                                echo '</div>';
                                            }
                                        ?>
                                        <div class="home-offers-product-title">
                                            <a href="<?php echo get_permalink($offer->ID); ?>"><h3><?php echo $offer->post_title; ?></h3></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="home-offers-mobile-slider-nav-wrapper">
                <div data-slider-button="prev" class="home-offers-mobile-slider-nav home-offers-mobile-slider-nav--prev"><?php include get_template_directory() . '/assets/icons/slider-prev-white-icon.svg'; ?></div>
                <div data-slider-button="next" class="home-offers-mobile-slider-nav home-offers-mobile-slider-nav--next"><?php include get_template_directory() . '/assets/icons/slider-next-white-icon.svg'; ?></div>
            </div>
        </div>
        <div class="home-offers-link">
            <a href="<?php echo get_site_url(); ?>/offers/">δείτε όλες τις Προσφορές</a>
        </div>
    </div>
</section>
<?php } ?>