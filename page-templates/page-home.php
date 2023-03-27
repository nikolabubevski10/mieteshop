<?php
/**
 * Template Name: Home Page
 */
?>
<?php get_header(); ?>

<?php
    if ( have_posts() ) {
        while ( have_posts() ){
            the_post();

            get_template_part( 'page-sections/three', 'banner' );
            get_template_part( 'page-sections/home', 'new-releases-miet' );            
            get_template_part( 'page-sections/home', 'new-releases' );
            get_template_part( 'page-sections/home', 'rare-editions-miet' );            
            get_template_part( 'page-sections/home', 'rare-editions' );
            get_template_part( 'page-sections/home', 'offers' );
            get_template_part( 'page-sections/middle', 'banner' );
            get_template_part( 'page-sections/home', 'book-week' );
            get_template_part( 'page-sections/home', 'suggestion' );
            get_template_part( 'page-sections/home', 'thematic' );
            get_template_part( 'page-sections/home', 'authors' );
            get_template_part( 'page-sections/home', 'blog' );
        }
    }
?>

<?php get_footer(); ?>