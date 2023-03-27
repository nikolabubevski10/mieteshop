<?php get_header(); ?>

<?php
    if ( have_posts() ) {
        while ( have_posts() ){
            the_post();

            get_template_part( 'page-sections/publisher/single', 'publisher-info' );
            get_template_part( 'page-sections/publisher/single', 'publisher-meta' );
            get_template_part( 'page-sections/publisher/single', 'publisher-books' );
            get_template_part( 'page-sections/publisher/single', 'publisher-miet' );
            get_template_part( 'page-sections/publisher/single', 'publisher-authors' );
        }
    }
?>

<div id="js-single-publisher-product-filter-load-spinner" class="load-spinner hide"></div>

<?php get_footer(); ?>