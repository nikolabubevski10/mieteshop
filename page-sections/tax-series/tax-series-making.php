<?php 
    $current_series_taxonomy = get_queried_object();
    
    $series_gallery_images = get_field('series_image_gallery', 'series_'.$current_series_taxonomy->term_id);
    $series_sampling = get_field('series_sampling', 'series_'.$current_series_taxonomy->term_id);

    if( $series_gallery_images || have_rows('series_videos', 'series_'.$current_series_taxonomy->term_id) || $series_sampling ) {
?>
        <section class="series-makingof-title">
            <div class="general-container">
            <div class="series-image-gallery-title">
                <h2>MAKING OF & ΣΧΕΤΙΚΑ</h2>
            </div>
            </div>    
        </section>    
<?php
    }
?>