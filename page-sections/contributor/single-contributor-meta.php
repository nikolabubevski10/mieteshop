<?php
    if( have_rows('contributor_videos') || get_field('contributor_related_articles') ) {
?>
        <section class="single-contributor-meta-section" is="mieteshop-contributor-meta-section">
            <div class="content-container">
                <div class="single-contributor-meta-tab-row">
                    <div class="single-contributor-meta-tab-col">
                        <div class="single-contributor-meta-tab-item active" data-section-id="video" data-tab>Video</div>
                    </div>
                    <div class="single-contributor-meta-tab-col">
                        <div class="single-contributor-meta-tab-item" data-section-id="article" data-tab>Σχετικά  Άρθρα</div>
                    </div>
                </div>
                <div class="single-contributor-meta-tab-content-row">
                    <div id="single-contributor-meta-tab-content--video" class="single-contributor-meta-tab-content-col">
                        <div class="single-contributor-video-wrapper" is="mieteshop-contributor-video-slider">
                            <div class="swiper-container" data-video-slider>
                                <div class="swiper-wrapper">
                                    <?php
                                    if( have_rows('contributor_videos') ) { 
                                        while( have_rows('contributor_videos') ){
                                            the_row();

                                            $video_image_url = get_sub_field('contributor_video_cover_image');
                                    ?>
                                            <div class="swiper-slide">
                                                <div class="single-contributor-video-item-row">
                                                    <div class="single-contributor-video-item-left-col">
                                                        <div class="js-sc-video-image-wrapper single-contributor-video-image-wrapper">
                                                            <img
                                                                class="lazyload"
                                                                src="<?php echo placeholderImage(606, 241); ?>"
                                                                data-src="<?php echo aq_resize($video_image_url['url'], 606, 241, true); ?>"
                                                                alt="video image">
                                                            <div class="single-product-video-play-icon"><?php include get_template_directory() . '/assets/icons/video-play-icon.svg' ?></div>
                                                            <div class="single-product-video-resize-icon"><?php include get_template_directory() . '/assets/icons/resize-icon.svg' ?></div>
                                                        </div>
                                                        <div class="single-contributor-video-hidden"><?php echo get_sub_field('contributor_video_embed_code'); ?></div>
                                                    </div>
                                                    <div class="single-contributor-video-item-right-col">
                                                        <div class="single-contributor-video-item-content">
                                                            <h2><?php echo get_sub_field('contributor_video_title'); ?></h2>
                                                            <?php echo apply_filters('the_content', get_sub_field('contributor_video_description')); ?>
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
                            <div class="single-contributor-video-pagination-wrapper" data-video-pagination></div>
                        </div>
                    </div>
                    <div id="single-contributor-meta-tab-content--article" class="single-contributor-meta-tab-content-col hide">
                        <div class="single-contributor-blog-wrapper" is="mieteshop-contributor-blog-slider">
                            <div class="swiper-container"  data-blog-slider>
                                <div class="swiper-wrapper">
                                    <?php
                                        $related_articles = get_field('contributor_related_articles');
                                        foreach($related_articles as $article) {
                                            $blog_image_url = wp_get_attachment_url( get_post_thumbnail_id($article->ID) );
                                    ?>
                                            <div class="single-contributor-blog-item swiper-slide">
                                                <div class="single-contributor-blog-item-inner">
                                                    <div class="single-contributor-blog-image">
                                                        <a href="<?php echo get_permalink($article->ID); ?>">
                                                            <img
                                                                class="lazyload"
                                                                src="<?php echo placeholderImage(399, 261); ?>"
                                                                data-src="<?php echo aq_resize($blog_image_url, 399, 261, true); ?>"
                                                                alt="video image">
                                                        </a>
                                                    </div>
                                                    <div class="single-contributor-blog-content">
                                                        <h2><a href="<?php echo get_permalink($article->ID); ?>"><?php echo $article->post_title; ?></a></h2>
                                                        <?php echo get_field('post_lead', $article->ID); //apply_filters('the_content', $article->post_excerpt); ?>
                                                    </div>
                                                </div>
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