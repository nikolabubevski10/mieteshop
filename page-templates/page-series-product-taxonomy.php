<?php
/**
 * Template Name: Series Product Taxonomy
 */
?>
<?php get_header(); ?>

<?php
    global $post;

    if ( have_posts() ) {
        while ( have_posts() ){
            the_post();
?>
<section class="single-publisher-title">
    <div class="content-container">
        <h1><?php echo $post->post_title; ?></h1>
    </div>
</section>
<?php
        }
    }
?>
<section class="single-product-series-section single-product-series-section--no-border-top">
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

<?php get_footer(); ?>