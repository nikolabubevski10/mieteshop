<?php
    $series_gallery_images = get_field('series_image_gallery', 'series_'.$current_series_taxonomy->term_id);
?>
<section class="series-image-gallery-section">
    <div class="general-container">
        <?php
            
            if ($series_gallery_images) {     
            ?>
            <section><div class="general-container"><div class="content-container">
            <div class="single-post-slider-row" is="mieteshop-post-slider">
                <div class="single-post-slider-big-wrapper">
                    <div class="swiper-container" data-big-slider>
                        <div class="swiper-wrapper">
                            <?php
                            foreach( $series_gallery_images as $image ) {
                            ?>
                                <div class="swiper-slide">
                                    <!--a href="<?php //echo esc_url($image['url']); ?>"></a-->
                                    <img class="lazyload" src="<?php echo esc_url($image['url']); ?>" data-src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                </div>
                            <?php
                            }
                            ?>    
                        </div>
                    </div>
                    <div class="single-post-slider-big-nav-wrapper">
                        <div data-slider-button="prev" class="single-post-slider-big-nav single-post-slider-big-nav--prev"><?php include get_template_directory() . '/assets/icons/slider-prev-icon.svg'; ?></div>
                        <div data-slider-button="next" class="single-post-slider-big-nav single-post-slider-big-nav--next"><?php include get_template_directory() . '/assets/icons/slider-next-icon.svg'; ?></div>
                    </div>
                </div>
                <div class="single-post-slider-small-wrapper">
                    <div class="swiper-container" data-small-slider>
                        <div class="swiper-wrapper">
                            <?php
                            //$thumbs = get_sub_field('post_image_gallery');
                            $i=1;
                            foreach( $series_gallery_images as $image ) {
                            ?>
                            <div class="swiper-slide single-post-slider-small-item item-'<?php echo $i; ?>'">
                                <img class="lazyload" src="<?php echo esc_url($image['sizes']['woocommerce_gallery_thumbnail']); ?>" data-src="<?php echo $image['sizes']['woocommerce_gallery_thumbnail']; ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                            </div>
                            <?php
                            $i++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            </div></div></section>
            <?php
            }        
   
        ?>
    </div>
</section>