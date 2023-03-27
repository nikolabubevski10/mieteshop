<?php
    global $post;

    if($post->ID == 733 ) {
        //only show series for publisher MIET
?>
        <section class="single-product-series-section">
            <div class="small-container">
                <div class="single-product-series-title">
                    <h2>ΣΕΙΡΕΣ</h2>
                </div>
                <div class="single-product-series-row">
                    <?php
                        $series = get_terms([
                            'taxonomy' => 'series',
                            'hide_empty' => false,       
                        ]);

                        foreach($series as $series_term) {
                            $series_image = get_field('series_image', 'series_'.$series_term->term_id);
                    ?>
                            <div class="single-product-series-col">
                                <div class="single-product-series-item">
                                    <div class="single-product-series-item-image">
                                        <a href="<?php echo esc_url( get_term_link( $series_term->term_id ) ); ?>">
                                            <img
                                                class="lazyload"
                                                src="<?php echo placeholderImage(300, 160); ?>"
                                                data-src="<?php echo aq_resize($series_image['url'], 300, 160, true); ?>"
                                                alt="<?php echo $series_term->name; ?>">
                                        </a>
                                    </div>
                                    <div class="single-product-series-item-title">
                                        <h3><a href="<?php echo esc_url( get_term_link( $series_term->term_id ) ); ?>"><?php echo $series_term->name; ?></a></h3>
                                    </div>
                                    <div class="single-product-series-item-info">
                                        <p><strong><?php echo $series_term->count; ?></strong> τίτλοι</p>
                                    </div>
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