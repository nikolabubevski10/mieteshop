<?php
/**
 * Template Name: Terms Page
 */
global $post;
?>
<?php get_header(); ?>
<section class="single-publisher-title">
    <div class="content-container">
        <h1><?php echo get_the_title(); ?></h1>
    </div>
</section>
<?php if( have_rows('page_toc_content_field') ) { ?>
<section class="terms-cat-section">
    <div class="content-container">
        <div class="terms-cat-title">Περιεχόμενα:</div>
        <div class="terms-cat-row">            
        <div class="terms-cat-item">
            <?php while( have_rows('page_toc_content_field') ) { the_row(); ?>
            <a href="#<?php echo url_slug(get_sub_field('page_toc_title'), array('transliterate' => true)) ?>"><?php echo get_sub_field('page_toc_title'); ?></a> &middot; 
            <?php } ?>    
        </div>    
        </div>
    </div>
</section>
<section class="terms-content-section">
    <div class="general-container">
        <div class="content-container">
            <?php while( have_rows('page_toc_content_field') ) { the_row(); ?>
            <div class="terms-content-row" id="<?php echo url_slug(get_sub_field('page_toc_title'), array('transliterate' => true)) ?>">
                <div class="terms-content-left-col">
                    <h2><?php echo get_sub_field('page_toc_title'); ?></h2>
                </div>
                <div class="terms-content-right-col">
                    <?php echo get_sub_field('page_toc_content'); ?>
                </div>
            </div>
            <?php } ?>              
        </div>
    </div>
</section>
<?php } ?>
<?php get_footer(); ?>