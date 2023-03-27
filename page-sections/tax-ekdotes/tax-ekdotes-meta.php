<?php
    $current_ekdotes_taxonomy = get_queried_object();
    $ekdotes_image = get_field('ekdotes_image', 'ekdotes_'.$current_ekdotes_taxonomy->term_id);

    if( have_rows('publisher_company_videos', 'ekdotes_'.$current_ekdotes_taxonomy->term_id ) || get_field('publisher_company_related_articles', 'ekdotes_'.$current_ekdotes_taxonomy->term_id) ) {
?>
        <section class="single-publisher-meta-section" is="mieteshop-publisher-meta-section">
            <div class="content-container">

                <div class="single-publisher-meta-tab-row">
                    <?php
                        if( have_rows('publisher_company_videos', 'ekdotes_'.$current_ekdotes_taxonomy->term_id ) ){
                    ?>
                            <div class="single-publisher-meta-tab-col">
                                <div class="single-publisher-meta-tab-item active" data-section-id="video" data-tab>Video</div>
                            </div>
                    <?php
                        }
                    ?>
                    <?php
                        if( have_rows('publisher_company_related_articles', 'ekdotes_'.$current_ekdotes_taxonomy->term_id ) ){
                    ?>
                            <div class="single-publisher-meta-tab-col">
                                <div class="single-publisher-meta-tab-item" data-section-id="article" data-tab>Σχετικά  Άρθρα</div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="single-publisher-meta-tab-content-row">
                    <?php
                        if( have_rows('publisher_company_videos', 'ekdotes_'.$current_ekdotes_taxonomy->term_id) ) {
                            $is_video_slider = count(get_field('publisher_company_videos', 'ekdotes_'.$current_ekdotes_taxonomy->term_id)) > 1 ? true : false;
                    ?>
                            <div id="single-publisher-meta-tab-content--video" class="single-publisher-meta-tab-content-col">
                                <div class="single-publisher-video-wrapper">
                                    <?php
                                        if( $is_video_slider ){
                                    ?>
                                            <div class="swiper-container" data-video-slider>
                                                <div class="swiper-wrapper">
                                                    <?php
                                                        while( have_rows('publisher_company_videos', 'ekdotes_'.$current_ekdotes_taxonomy->term_id) ){
                                                            the_row();

                                                            $video_image_url = get_sub_field('publisher_company_video_cover_image', 'ekdotes_'.$current_ekdotes_taxonomy->term_id);
                                                    ?>
                                                            <div class="swiper-slide">
                                                                <div class="single-publisher-video-item-row">
                                                                    <div class="single-publisher-video-item-left-col">
                                                                        <div class="js-sc-video-image-wrapper single-publisher-video-image-wrapper">
                                                                            <img
                                                                                class="lazyload"
                                                                                src="<?php echo placeholderImage(606, 241); ?>"
                                                                                data-src="<?php echo aq_resize($video_image_url['url'], 606, 241, true); ?>"
                                                                                alt="video image">
                                                                            <div class="single-publisher-video-play-icon"><?php include get_template_directory() . '/assets/icons/video-play-icon.svg' ?></div>
                                                                            <div class="single-publisher-video-resize-icon"><?php include get_template_directory() . '/assets/icons/resize-icon.svg' ?></div>
                                                                        </div>
                                                                        <div class="single-contributor-video-hidden"><?php echo get_sub_field('publisher_company_video_embed_code', 'ekdotes_'.$current_ekdotes_taxonomy->term_id); ?></div>
                                                                    </div>
                                                                    <div class="single-publisher-video-item-right-col">
                                                                        <div class="single-publisher-video-item-content">
                                                                            <h2><?php echo get_sub_field('publisher_company_video_title', 'ekdotes_'.$current_ekdotes_taxonomy->term_id); ?></h2>
                                                                            <?php echo apply_filters('the_content', get_sub_field('publisher_company_video_description', 'ekdotes_'.$current_ekdotes_taxonomy->term_id)); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }                         
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="single-publisher-video-pagination-wrapper" data-video-pagination></div>
                                    <?php
                                        } else {
                                            while( have_rows('publisher_company_videos', 'ekdotes_'.$current_ekdotes_taxonomy->term_id) ){
                                                the_row();

                                                $video_image_url = get_sub_field('publisher_company_video_cover_image', 'ekdotes_'.$current_ekdotes_taxonomy->term_id);
                                    ?>
                                                <div class="single-publisher-video-item-row">
                                                    <div class="single-publisher-video-item-left-col">
                                                        <div class="js-sc-video-image-wrapper single-publisher-video-image-wrapper">
                                                            <img
                                                                class="lazyload"
                                                                src="<?php echo placeholderImage(606, 241); ?>"
                                                                data-src="<?php echo aq_resize($video_image_url['url'], 606, 241, true); ?>"
                                                                alt="video image">
                                                            <div class="single-publisher-video-play-icon"><?php include get_template_directory() . '/assets/icons/video-play-icon.svg' ?></div>
                                                            <div class="single-publisher-video-resize-icon"><?php include get_template_directory() . '/assets/icons/resize-icon.svg' ?></div>
                                                        </div>
                                                        <div class="single-contributor-video-hidden"><?php echo get_sub_field('publisher_company_video_embed_code', 'ekdotes_'.$current_ekdotes_taxonomy->term_id); ?></div>
                                                    </div>
                                                    <div class="single-publisher-video-item-right-col">
                                                        <div class="single-publisher-video-item-content">
                                                            <h2><?php echo get_sub_field('publisher_company_video_title', 'ekdotes_'.$current_ekdotes_taxonomy->term_id); ?></h2>
                                                            <?php echo apply_filters('the_content', get_sub_field('publisher_company_video_description', 'ekdotes_'.$current_ekdotes_taxonomy->term_id)); ?>
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
                        $related_articles = get_field('publisher_company_related_articles', 'ekdotes_'.$current_ekdotes_taxonomy->term_id);
                        if ( !empty($related_articles) ) {
                            $is_articles_slider = count(get_field('publisher_company_related_articles', 'ekdotes_'.$current_ekdotes_taxonomy->term_id)) > 2 ? true : false;
                    ?>
                            <div id="single-publisher-meta-tab-content--article" class="single-publisher-meta-tab-content-col hide">
                                <div class="single-publisher-blog-wrapper">
                                    <?php
                                        if( $is_articles_slider ){
                                    ?>
                                        <div class="swiper-container" data-blog-slider>
                                            <div class="swiper-wrapper">
                                                <?php
                                                    foreach($related_articles as $article) {
                                                        $blog_image_url = wp_get_attachment_url( get_post_thumbnail_id($article->ID) );
                                                ?>
                                                        <div class="single-publisher-blog-item swiper-slide">
                                                            <div class="single-publisher-blog-item-inner">
                                                                <div class="single-publisher-blog-image">
                                                                    <a href="<?php echo get_permalink($article->ID); ?>">
                                                                        <img
                                                                            class="lazyload"
                                                                            src="<?php echo placeholderImage(399, 261); ?>"
                                                                            data-src="<?php echo aq_resize($blog_image_url, 399, 261, true); ?>"
                                                                            alt="video image">
                                                                    </a>
                                                                </div>
                                                                <div class="single-publisher-blog-content">
                                                                    <h2><a href="<?php echo get_permalink($article->ID); ?>"><?php echo $article->post_title; ?></a></h2>
                                                                    <?php echo apply_filters('the_content', $article->post_excerpt); ?>
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
                                                <div class="single-publisher-blog-item">
                                                    <div class="single-publisher-blog-item-inner">
                                                        <div class="single-publisher-blog-image">
                                                            <a href="<?php echo get_permalink($article->ID); ?>">
                                                                <img
                                                                    class="lazyload"
                                                                    src="<?php echo placeholderImage(399, 261); ?>"
                                                                    data-src="<?php echo aq_resize($blog_image_url, 399, 261, true); ?>"
                                                                    alt="video image">
                                                            </a>
                                                        </div>
                                                        <div class="single-publisher-blog-content">
                                                            <h2><a href="<?php echo get_permalink($article->ID); ?>"><?php echo $article->post_title; ?></a></h2>
                                                            <?php echo apply_filters('the_content', $article->post_excerpt); ?>
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