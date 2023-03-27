<?php get_header(); ?>

<?php
    //if ( have_posts() ) {
    //    while ( have_posts() ){
            //the_post();

            get_template_part( 'page-sections/tax-ekdotes/tax-ekdotes', 'info' );
            get_template_part( 'page-sections/tax-ekdotes/tax-ekdotes', 'meta' );
            get_template_part( 'page-sections/tax-ekdotes/tax-ekdotes', 'books' );
            get_template_part( 'page-sections/tax-ekdotes/tax-ekdotes', 'miet' );
            get_template_part( 'page-sections/tax-ekdotes/tax-ekdotes', 'authors' );
        //}
   //}
?>

<div id="js-single-publisher-product-filter-load-spinner" class="load-spinner hide"></div>

<?php get_footer(); ?>