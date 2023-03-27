<?php
    /**
     * Post card of list
     * Template args
     * postID : post ID
     */
    $greek_month_list = ['ΙΑΝ', 'ΦΕΒ', 'ΜΆΡ', 'ΑΠΡ', 'ΜΆΙ', 'ΙΟΎΝ', 'ΙΟΎΛ', 'ΑΎΓ', 'ΣΕΠ', 'ΟΚΤ', 'ΝΟΈ', 'ΔΕΚ'];
    
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $args['postId'] ), 'full' );
    $post_title = get_the_title($args['postId']);
?>
<div id="js-blog-first" class="blog-first">
    <div class="blog-first-image">
        <a href="<?php echo get_permalink($args['postId']); ?>">
            <img
                class="lazyload"
                src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                alt="<?php echo $post_title; ?>">
        </a>    
    </div>
    <div class="blog-first-content">
        <div class="blog-first-content-inner">
            <div class="blog-first-content-meta-row">
                <div class="blog-first-content-category-list">
                    <div class="blog-first-content-category-col">
                    <?php
                        $terms = wp_get_post_terms( $args['postId'], 'category' );
                        foreach ( $terms as $term ) {
                    ?>
                            <a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a> 
                    <?php
                        }
                    ?>
                    </div>
                </div>
                <div class="blog-first-content-date"><?php echo get_the_date('j', $args['postId']); ?> <?php echo $greek_month_list[get_the_date('n', $args['postId']) - 1]; ?> <?php echo get_the_date('Y', $args['postId']); ?></div>
            </div>
            <div class="blog-first-content-info">
                <h2><a href="<?php echo get_permalink($args['postId']); ?>"><?php echo $post_title; ?></a></h2>
            </div>
            <div class="blog-first-content-des">
                <?php echo get_field('post_lead', $args['postId']) ?>                                
            </div>
        </div>
    </div>
</div>