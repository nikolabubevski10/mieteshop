<?php get_header(); ?>

<?php

    if ( have_posts() ) {
        while ( have_posts() ){
            the_post();

            get_template_part( 'page-sections/contributor/single', 'contributor-info' );
            get_template_part( 'page-sections/contributor/single', 'contributor-meta' );
            get_template_part( 'page-sections/contributor/single', 'contributor-books' );
            get_template_part( 'page-sections/contributor/single', 'contributor-participated-in' );
            get_template_part( 'page-sections/contributor/single', 'contributor-related-books' );
        }
    }
?>

<div id="js-single-contributor-product-filter-load-spinner" class="load-spinner hide"></div>

<?php get_footer(); ?>