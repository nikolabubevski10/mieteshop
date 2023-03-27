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
<div class="blog-result-col">
    <div class="home-blog-item">
        <div class="home-blog-item-image">
            <a href="<?php echo get_permalink($args['postId']); ?>">
                <img
                    class="lazyload"
                    src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                    data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                    alt="<?php echo $post_title; ?>">
            </a>
        </div>
        <div class="home-blog-item-meta-row">
            <div class="home-blog-item-category-list">
                <?php
                    $category_list = get_the_category($args['postId']);
                    foreach( $category_list as $category ){
                ?>
                        <div class="home-blog-item-category-col"><a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a></div>
                <?php
                    }
                ?>
            </div>
            <div class="home-blog-item-date"><?php echo get_the_date('j', $args['postId']); ?> <?php echo $greek_month_list[get_the_date('n', $args['postId']) - 1]; ?> <?php echo get_the_date('Y', $args['postId']); ?></div>
        </div>
        <div class="home-blog-item-title">
            <h3><a href="<?php echo get_permalink($args['postId']); ?>"><?php echo $post_title; ?></a></h3>
        </div>
        <div class="blog-item-bottom-row">
            <div class="blog-item-bottom-left-col">
                <?php if(get_field('event_from_date', $args['postId'])) { ?>
                <div class="home-blog-item-duration-row">
                    <div class="home-blog-item-duration-col">
                        <div class="home-blog-item-duration-label">ΑΠΟ</div>
                        <div class="home-blog-item-duration-date"><?php echo get_field('event_from_date', $args['postId']); ?></div>
                    </div>
                    <div class="home-blog-item-duration-col">
                        <div class="home-blog-item-duration-label">ΕΩΣ</div>
                        <div class="home-blog-item-duration-date"><?php echo get_field('event_to_date', $args['postId']); ?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="blog-item-bottom-right-col">
                <div class="home-blog-item-excerpt">
                    <?php echo get_field('post_lead', $args['postId']); ?>
                </div>
            </div>
        </div>
    </div>
</div>