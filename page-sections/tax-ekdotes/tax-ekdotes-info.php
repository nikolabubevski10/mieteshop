<?php
    global $post;
    $current_ekdotes_taxonomy = get_queried_object();
    $ekdotes_image = get_field('ekdotes_image', 'ekdotes_'.$current_ekdotes_taxonomy->term_id);
?>
<section class="single-publisher-title">
    <div class="content-container">
        <h1><?php echo $current_ekdotes_taxonomy->name; ?></h1>
    </div>
</section>
<section class="single-publisher-image-lead-section">
    <div class="general-container">
        <div class="content-container">
            <div class="single-publisher-image-lead-row">
                <div class="single-publisher-image-lead-left">
                    <?php //$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                    <div class="single-publisher-image-lead-image">
                    <img class="lazyload"
                        src="<?php echo placeholderImage($ekdotes_image['width'], $ekdotes_image['height']); ?>"
                        data-src="<?php echo $ekdotes_image['url']; ?>"
                        alt="<?php echo $current_ekdotes_taxonomy->name; ?>">
                    </div>
                </div>
                <div class="single-publisher-image-lead-right">
                    <div class="single-publisher-image-lead-content">
                        <?php echo apply_filters('the_content', get_field('publisher_company_description_lead', 'ekdotes_'.$current_ekdotes_taxonomy->term_id)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="single-publisher-text-caption-section">
    <div class="content-container">
        <div class="single-publisher-text-caption-row">
            <div class="single-publisher-text-caption-left"><span style="display: none;">Λεζάντα φωτογραφίας με credit</span></div>
            <div class="single-publisher-text-caption-right">
                <div class="single-publisher-text-caption-content">
                    <?php echo apply_filters('the_content', $current_ekdotes_taxonomy->description); ?>
                </div>
                <div class="single-publisher-text-caption-download" style="display: none;">
                    <a href="#">Κατεβάστε τον κατάλογο (7Mb)</a>
                </div>
            </div>
        </div>
    </div>
</section>