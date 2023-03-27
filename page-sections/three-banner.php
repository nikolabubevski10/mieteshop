<section class="three-banner">
    <div class="general-container">
        <?php
            $top_banner_2 = get_field('top_banner_2');
            $top_banner_3 = get_field('top_banner_3');
        ?>
        <div class="wide-container">
            <div class="three-banner-row">
                <div class="three-banner-left-col">
                    <div class="three-banner-1-slider-wrapper" is="mieteshop-three-banner-1-slider">
                        <div class="swiper-container" data-slider>
                            <div class="swiper-wrapper">
                                <?php
                                    if( have_rows('top_banner_1_list') ){
                                        while( have_rows('top_banner_1_list') ){
                                            the_row();
                                            $image = get_sub_field('image');
                                ?>
                                            <div class="swiper-slide">
                                                <div class="three-banner-1">
                                                    <img
                                                        class="lazyload"
                                                        src="<?php echo placeholderImage(720, 400); ?>"
                                                        data-src="<?php echo aq_resize($image['url'], 720, 400, true); ?>"
                                                        alt="<?php echo $image['alt']; ?>">
                                                    <div class="three-banner-1-content">
                                                        <h2><?php echo get_sub_field('title'); ?></h2>
                                                        <p><?php echo get_sub_field('content'); ?></p>
                                                        <div class="three-banner-1-link">
                                                            <?php $top_banner_1_link = get_sub_field('link'); ?>
                                                            <a href="<?php echo $top_banner_1_link['url']; ?>"><?php echo $top_banner_1_link['title']; ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="three-banner-1-slider-nav-wrapper">
                            <div data-slider-button="prev" class="three-banner-1-slider-nav three-banner-1-slider-nav--prev"><?php include get_template_directory() . '/assets/icons/slider-prev-icon.svg'; ?></div>
                            <div data-slider-button="next" class="three-banner-1-slider-nav three-banner-1-slider-nav--next"><?php include get_template_directory() . '/assets/icons/slider-next-icon.svg'; ?></div>
                        </div>
                    </div>
                </div>
                <div class="three-banner-right-col">
                    <?php
                        $top_banner_2_link = get_field('top_banner_2_link');
                        $top_banner_3_link = get_field('top_banner_3_link');
                    ?>
                    <div class="three-banner-2">
                        <a href="<?php echo $top_banner_2_link; ?>">
                            <img
                                class="lazyload"
                                src="<?php echo placeholderImage(512, 230); ?>"
                                data-src="<?php echo aq_resize($top_banner_2['url'], 512, 230, true); ?>"
                                alt="<?php echo $top_banner_2['alt']; ?>">
                        </a>
                    </div>
                    <div class="three-banner-3">
                        <div class="three-banner-3-inner">
                            <a href="<?php echo $top_banner_3_link; ?>">
                                <img
                                    class="lazyload"
                                    src="<?php echo placeholderImage(512, 154); ?>"
                                    data-src="<?php echo aq_resize($top_banner_3['url'], 512, 154, true); ?>"
                                    alt="<?php echo $top_banner_3['alt']; ?>">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>