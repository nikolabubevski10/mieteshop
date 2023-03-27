<?php
/**
 * Template Name: My Account Page
 */
?>
<?php get_header(); ?>

<?php
    if( is_user_logged_in() ){
        $endpoint = WC()->query->get_current_endpoint();  
        $endpoint_title = WC()->query->get_endpoint_title( $endpoint );
        $endpoint_title = empty($endpoint_title) ? 'Λογαριασμός' : $endpoint_title;
?>
        <section class="my-account-title-section">
            <div class="content-container">
                <h1><?php echo $endpoint_title; ?></h1>
            </div>
        </section>
<?php
    }

    if ( have_posts() ) {
        while ( have_posts() ){
            the_post();
?>
<section class="my-account-section">
    <div class="content-container">
        <?php the_content(); ?>
    </div>
</section>
<?php
        }
    }
?>

<?php get_footer(); ?>