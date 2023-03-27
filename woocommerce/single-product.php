<?php
defined( 'ABSPATH' ) || exit;
get_header( 'shop' );

if ( have_posts() ) {
        
    while ( have_posts() ) {
        the_post();
        
        get_template_part( 'product/single', 'product' );
    }
}

get_footer( 'shop' );