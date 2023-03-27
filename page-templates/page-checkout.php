<?php
/**
 * Template Name: Checkout Page
 */
?>
<?php get_header(); ?>

<?php
    if ( have_posts() ) {
        while ( have_posts() ) :
            the_post();
?>
<section class="form-checkout-section">
    <div class="content-container">
        <div class="form-checkout-inner">
            <section class="form-checkout-title">
                <h1>Πληρωμή</h1>
            </section>
            <?php the_content(); ?>
        </div>
    </div>
</section>
<?php
        endwhile;
    }
?>

<?php get_footer(); ?>