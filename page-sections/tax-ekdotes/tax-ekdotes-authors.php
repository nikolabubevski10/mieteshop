<?php
    $current_ekdotes_taxonomy = get_queried_object();
    $company_selected_contributors = get_field('publisher_company_selected_contributors', 'ekdotes_'.$current_ekdotes_taxonomy->term_id);

    if( !empty($company_selected_contributors) ){
?>
        <section class="home-authors-section">
            <div class="small-container">
                <div class="home-authors-title">
                    <h2>ΣΥΓΓΡΑΦΕΙΣ</h2>
                </div>
                <div class="home-authors-row">
                    <?php
                        $aa=1;
                        foreach ( $company_selected_contributors as $contributor ){
                            if($aa <= 4) {
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $contributor->ID ), 'full' );
                    ?>
                            <div class="home-authors-col">
                                <div class="home-authors-image">
                                    <a href="<?php echo get_permalink($contributor->ID); ?>">
                                    <img
                                        class="lazyload"
                                        src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                        data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                        alt="<?php echo $contributor->post_title; ?>">
                                    </a>    
                                </div>
                                <div class="home-authors-name">
                                    <h3><a href="<?php echo get_permalink($contributor->ID); ?>"><?php echo $contributor->post_title; ?></a></h3>
                                </div>
                            </div>
                    <?php
                            }
                            $aa++;                    
                        }
                    ?>
                </div>
                <div class="home-authors-mobile-slider" is="mieteshop-home-authors-mobile-slider">
                    <div class="swiper-container" data-slider>
                        <div class="swiper-wrapper">
                            <?php
                                foreach( $company_selected_contributors as $contributor ){
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $contributor->ID ), 'full' );
                            ?>
                                    <div class="swiper-slide">
                                        <div class="home-authors-col">
                                            <div class="home-authors-image">
                                                <a href="<?php echo get_permalink($contributor->ID); ?>">
                                                    <img
                                                        class="lazyload"
                                                        src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                                        data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                                        alt="<?php echo $contributor->post_title; ?>">
                                                </a>
                                            </div>
                                            <div class="home-authors-name">
                                                <h3><a href="<?php echo get_permalink($contributor->ID); ?>"><?php echo $contributor->post_title; ?></a></h3>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="home-authors-mobile-slider-nav-wrapper">
                            <div data-slider-button="prev" class="home-authors-mobile-slider-nav home-authors-mobile-slider-nav--prev"><?php include get_template_directory() . '/assets/icons/slider-prev-white-icon.svg'; ?></div>
                            <div data-slider-button="next" class="home-authors-mobile-slider-nav home-authors-mobile-slider-nav--next"><?php include get_template_directory() . '/assets/icons/slider-next-white-icon.svg'; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php
    }
?>