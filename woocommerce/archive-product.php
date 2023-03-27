<?php
defined( 'ABSPATH' ) || exit;
get_header( 'shop' );

if( is_product_category() ){
    // product category page
    get_template_part( 'product/category', 'product' );
} else {
    // product shop page
    echo 'shop page';
}

get_footer( 'shop' );