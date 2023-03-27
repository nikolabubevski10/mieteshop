<?php if(get_field('homepage_authors_of_the_month_rel')) { ?>
<section class="home-authors-section">
    <div class="small-container">
        <div class="home-authors-title">
            <h2>ΟΙ ΣΥΓΓΡΑΦΕΙΣ ΤΟΥ ΜΗΝΑ</h2>
        </div>
        <div class="home-authors-row">
            <?php
                $homepage_authors_of_the_month_rel = get_field('homepage_authors_of_the_month_rel');

                foreach( $homepage_authors_of_the_month_rel as $author ){
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $author->ID ), 'full' );
            ?>
                    <div class="home-authors-col">
                        <div class="home-authors-image">
                            <a href="<?php echo get_permalink($author->ID); ?>">
                                <img
                                    class="lazyload"
                                    src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                    data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                    alt="<?php echo $author->post_title; ?>">
                            </a>
                        </div>
                        <div class="home-authors-name">
                            <h3><a href="<?php echo get_permalink($author->ID); ?>"><?php echo $author->post_title; ?></a></h3>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
        <div class="home-authors-mobile-slider" is="mieteshop-home-authors-mobile-slider">
            <div class="swiper-container" data-slider>
                <div class="swiper-wrapper">
                    <?php
                        $homepage_authors_of_the_month_rel = get_field('homepage_authors_of_the_month_rel');

                        foreach( $homepage_authors_of_the_month_rel as $author ){
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $author->ID ), 'full' );
                    ?>
                            <div class="swiper-slide">
                                <div class="home-authors-col">
                                    <div class="home-authors-image">
                                        <a href="<?php echo get_permalink($author->ID); ?>">
                                            <img
                                                class="lazyload"
                                                src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                                data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                                alt="<?php echo $author->post_title; ?>">
                                        </a>
                                    </div>
                                    <div class="home-authors-name">
                                        <h3><a href="<?php echo get_permalink($author->ID); ?>"><?php echo $author->post_title; ?></a></h3>
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
<?php } ?>    