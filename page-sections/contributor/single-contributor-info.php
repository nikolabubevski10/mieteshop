<?php
    global $post;
?>
<section class="single-publisher-title">
    <div class="content-container">
        <h1><?php echo $post->post_title; ?></h1>
    </div>
</section>
<section class="single-contributor-image-lead-section">
    <div class="general-container">
        <div class="content-container">
            <div class="single-contributor-image-lead-row">
                <div class="single-contributor-image-lead-left">
                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                    <div class="single-contributor-image-lead-image">
                        <img
                            class="lazyload"
                            src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                            data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                            alt="<?php echo $post->post_title; ?>">
                    </div>
                </div>
                <div class="single-contributor-image-lead-right">
                    <div class="single-contributor-image-lead-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</section>
<section class="single-publisher-text-caption-section">
    <div class="content-container">
        <div class="single-publisher-text-caption-row">
            <div class="single-publisher-text-caption-left"></div>
            <div class="single-publisher-text-caption-right">
                <div class="single-publisher-text-caption-content">
                    <?php echo apply_filters('the_content', get_field('contributor_bio_detail')); ?>
                </div>
            </div>
        </div>
    </div>
</section>