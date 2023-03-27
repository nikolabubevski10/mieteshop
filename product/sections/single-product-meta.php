<?php
    global $product;
    
    if( have_rows('book_reviews') || have_rows('book_audio_repeater') || have_rows('book_videos') || have_rows('book_related_articles')  ) {
?>
        <section class="single-product-meta-section" is="mieteshop-product-meta-section">
            <div class="content-container">
                <div class="single-product-meta-tab-row-wrapper">
                    <div class="single-product-meta-tab-row">
                        <?php if ( have_rows('book_reviews') ) { ?>
                        <div class="single-product-meta-tab-col">
                            <div class="single-product-meta-tab-item active" data-section-id="review" data-tab>Βιβλιοκρισίες</div>
                        </div>
                        <?php } ?>
                        <?php if ( have_rows('book_audio_repeater') ) { ?>
                        <div class="single-product-meta-tab-col">
                            <div class="single-product-meta-tab-item" data-section-id="audio" data-tab>Audio</div>
                        </div>
                        <?php } ?>
                        <?php if ( have_rows('book_videos') ) { ?>
                        <div class="single-product-meta-tab-col">
                            <div class="single-product-meta-tab-item" data-section-id="video" data-tab>Video</div>
                        </div>
                        <?php } ?>
                        <?php if ( have_rows('book_related_articles') ) { ?>
                        <div class="single-product-meta-tab-col">
                            <div class="single-product-meta-tab-item" data-section-id="article" data-tab>Σχετικά  Άρθρα</div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="single-product-meta-tab-content-row">
                    <?php
                        if( have_rows('book_reviews') ){
                            $is_book_reviews_slider = count(get_field('book_reviews')) > 1 ? true : false; 
                    ?>
                            <div id="single-product-meta-tab-content--review" class="single-product-meta-tab-content-col">
                                <div class="single-product-review-wrapper">
                                    <?php
                                        if( $is_book_reviews_slider ){
                                    ?>
                                            <div class="swiper-container" data-review-slider>
                                                <div class="swiper-wrapper">
                                                <?php
                                                    while( have_rows('book_reviews') ){
                                                        the_row();    
                                                ?>
                                                        <div class="swiper-slide">
                                                            <div class="single-product-review">
                                                                <div class="single-product-review__content">
                                                                    <p><?php echo get_sub_field('book_reviews_text'); ?></p>
                                                                </div>
                                                                <div class="single-product-review__autor"><a href="<?php echo get_sub_field('book_reviews_source_link'); ?>"><?php echo get_sub_field('book_reviews_source_text'); ?></a></div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="single-product-review-pagination-wrapper" data-review-pagination></div>
                                    <?php
                                        } else {
                                            while( have_rows('book_reviews') ){
                                                the_row();
                                    ?>
                                                <div class="single-product-review">
                                                    <div class="single-product-review__content">
                                                        <p><?php echo get_sub_field('book_reviews_text'); ?></p>
                                                    </div>
                                                    <div class="single-product-review__autor"><a href="<?php echo get_sub_field('book_reviews_source_link'); ?>"><?php echo get_sub_field('book_reviews_source_text'); ?></a></div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                    <?php
                        if( have_rows('book_audio_repeater') ){ 
                            $is_book_audio_slider = count(get_field('book_audio_repeater')) > 1 ? true : false; 
                    ?>
                            <div id="single-product-meta-tab-content--audio" class="single-product-meta-tab-content-col hide">
                                <div class="single-product-audio-wrapper">
                                    <?php
                                        if( $is_book_audio_slider ){
                                    ?>
                                            <div class="swiper-container" data-audio-slider>
                                                <div class="swiper-wrapper">
                                                    <?php
                                                        while( have_rows('book_audio_repeater') ){
                                                            the_row();
                                                    ?>
                                                            <div class="swiper-slide">
                                                                <div class="single-product-audio-row">
                                                                    <div class="single-product-audio__content">
                                                                        <?php echo get_sub_field('book_audio_embed_code'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="single-product-audio-pagination-wrapper" data-audio-pagination></div>
                                    <?php
                                        } else {
                                            while( have_rows('book_audio_repeater') ){
                                                the_row();
                                    ?>
                                                <div class="single-product-audio-row">
                                                    <div class="single-product-audio__content">
                                                        <?php echo get_sub_field('book_audio_embed_code'); ?>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                    <?php
                        if( have_rows('book_videos') ) {
                            $is_book_videos_slider = count(get_field('book_videos')) > 1 ? true : false;
                    ?>
                            <div id="single-product-meta-tab-content--video" class="single-product-meta-tab-content-col hide">
                                <div class="single-product-video-wrapper">
                                    <?php
                                        if( $is_book_videos_slider ){
                                    ?>
                                            <div class="swiper-container" data-video-slider>
                                                <div class="swiper-wrapper">
                                                    <?php
                                                        while( have_rows('book_videos') ){
                                                            the_row();

                                                            $video_image_url = get_sub_field('contributor_video_cover_image');
                                                    ?>
                                                            <div class="swiper-slide">
                                                                <div class="single-product-video-item-row">
                                                                    <div class="single-product-video-item-left-col">
                                                                        <div class="js-sc-video-image-wrapper single-product-video-image-wrapper">
                                                                            <img
                                                                                class="lazyload"
                                                                                src="<?php echo placeholderImage(606, 241); ?>"
                                                                                data-src="<?php echo aq_resize($video_image_url['url'], 606, 241, true); ?>"
                                                                                alt="video image">
                                                                            <div class="single-product-video-play-icon"><?php include get_template_directory() . '/assets/icons/video-play-icon.svg' ?></div>
                                                                            <div class="single-product-video-resize-icon"><?php include get_template_directory() . '/assets/icons/resize-icon.svg' ?></div>
                                                                            <div class="single-contributor-video-hidden"><?php echo get_sub_field('contributor_video_embed_code'); ?></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="single-product-video-item-right-col">
                                                                        <div class="single-product-video-item-content">
                                                                            <h2><?php echo get_sub_field('contributor_video_title'); ?></h2>
                                                                            <?php echo apply_filters('the_content', get_sub_field('contributor_video_description')); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="single-product-video-pagination-wrapper" data-video-pagination></div>
                                    <?php
                                        } else {
                                            while( have_rows('book_videos') ){
                                                the_row();

                                                $video_image_url = get_sub_field('contributor_video_cover_image');
                                    ?>
                                                <div class="single-product-video-item-row">
                                                    <div class="single-product-video-item-left-col">
                                                        <div class="js-sc-video-image-wrapper single-product-video-image-wrapper">
                                                            <img
                                                                class="lazyload"
                                                                src="<?php echo placeholderImage(606, 241); ?>"
                                                                data-src="<?php echo aq_resize($video_image_url['url'], 606, 241, true); ?>"
                                                                alt="video image">
                                                            <div class="single-product-video-play-icon"><?php include get_template_directory() . '/assets/icons/video-play-icon.svg' ?></div>
                                                            <div class="single-product-video-resize-icon"><?php include get_template_directory() . '/assets/icons/resize-icon.svg' ?></div>
                                                            <div class="single-contributor-video-hidden"><?php echo get_sub_field('contributor_video_embed_code'); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="single-product-video-item-right-col">
                                                        <div class="single-product-video-item-content">
                                                            <h2><?php echo get_sub_field('contributor_video_title'); ?></h2>
                                                            <?php echo apply_filters('the_content', get_sub_field('contributor_video_description')); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                    <?php 
                        $related_articles = get_field('book_related_articles');   
                        if ( !empty($related_articles) ) {
                            $is_articles_slider = count(get_field('book_related_articles')) > 2 ? true : false;
                    ?>
                            <div id="single-product-meta-tab-content--article" class="single-product-meta-tab-content-col hide">
                                <div class="single-product-blog-wrapper">
                                    <?php
                                        if( $is_articles_slider ){
                                    ?>
                                            <div class="swiper-container" data-blog-slider>
                                                <div class="swiper-wrapper">
                                                    <?php
                                                        foreach($related_articles as $article) {
                                                            $blog_image_url = wp_get_attachment_url( get_post_thumbnail_id($article->ID) );
                                                    ?>
                                                            <div class="single-product-blog-item swiper-slide">
                                                                <div class="single-product-blog-item-inner">
                                                                    <div class="single-product-blog-image">
                                                                        <a href="<?php echo get_permalink($article->ID); ?>">
                                                                            <img
                                                                                class="lazyload"
                                                                                src="<?php echo placeholderImage(399, 261); ?>"
                                                                                data-src="<?php echo aq_resize($blog_image_url, 399, 261, true); ?>"
                                                                                alt="video image">
                                                                        </a>
                                                                    </div>
                                                                    <div class="single-product-blog-content">
                                                                        <h2><a href="<?php echo get_permalink($article->ID); ?>"><?php echo $article->post_title; ?></a></h2>
                                                                        <?php echo apply_filters('the_content', get_field('post_lead', $article->ID)); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                    <?php
                                        } else {
                                            foreach($related_articles as $article) {
                                                $blog_image_url = wp_get_attachment_url( get_post_thumbnail_id($article->ID) );
                                    ?>
                                                <div class="single-product-blog-item">
                                                    <div class="single-product-blog-item-inner">
                                                        <div class="single-product-blog-image">
                                                            <a href="<?php echo get_permalink($article->ID); ?>">
                                                                <img
                                                                    class="lazyload"
                                                                    src="<?php echo placeholderImage(399, 261); ?>"
                                                                    data-src="<?php echo aq_resize($blog_image_url, 399, 261, true); ?>"
                                                                    alt="video image">
                                                            </a>
                                                        </div>
                                                        <div class="single-product-blog-content">
                                                            <h2><a href="<?php echo get_permalink($article->ID); ?>"><?php echo $article->post_title; ?></a></h2>
                                                            <?php echo apply_filters('the_content', get_field('post_lead', $article->ID)); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </section>
<?php
    }
?>
<div id="js-sc-video-popup" class="single-contributor-video-popup hide">
    <div id="js-sc-video-popup__close-btn" class="single-contributor-video-popup__close-btn"></div>
    <div class="single-contributor-video-popup__video">
        <div id="js-sc-video-popup__video-wrapper">
        </div>
    </div>
</div>