<?php get_header(); ?>
<?php
    get_template_part( 'page-sections/tax-series/tax-series', 'info' );
    get_template_part( 'page-sections/tax-series/tax-series', 'books' );
    get_template_part( 'page-sections/tax-series/tax-series', 'making' );
    get_template_part( 'page-sections/tax-series/tax-series', 'gallery' );
    get_template_part( 'page-sections/tax-series/tax-series', 'meta' );
    get_template_part( 'page-sections/tax-series/tax-series', 'sampling' );
?>
<div id="js-ts-product-filter-load-spinner" class="load-spinner hide"></div>
<?php get_footer(); ?>