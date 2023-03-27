<?php
/**
 * Template Name: Cart Page
 */
?>
<?php get_header(); ?>

<?php
    if ( have_posts() ) {
        while ( have_posts() ){
            the_post();
?>
<section class="cart-page-title">
    <div class="content-container">
        <h1>Καλάθι αγορών</h1>
    </div>
</section>
<?php
            the_content();
        }
    }
?>

<?php get_footer(); ?>