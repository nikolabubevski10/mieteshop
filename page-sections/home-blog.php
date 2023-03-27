<section class="home-blog">
    <div class="general-container">
        <div class="small-container">
            <div class="home-blog-title">
                <h2>ΝΕΑ & ΕΚΔΗΛΩΣΕΙΣ</h2>
            </div>
            <div class="home-blog-slider-wrapper"  is="mieteshop-home-blog-slider">
                <div class="swiper-container" data-slider>
                    <div class="swiper-wrapper">
                        <?php
                            $homepage_blog_posts_rel = get_field('homepage_blog_posts_rel');

                            $greek_month_list = ['ΙΑΝ', 'ΦΕΒ', 'ΜΑΡ', 'ΑΠΡ', 'ΜΆΙ', 'ΙΟΥΝ', 'ΙΟΥΛ', 'ΑΥΓ', 'ΣΕΠ', 'ΟΚΤ', 'ΝΟΕ', 'ΔΕΚ'];

                            foreach( $homepage_blog_posts_rel as $blog ){
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $blog->ID ), 'full' );
                        ?>
                                <div class="swiper-slide">
                                    <div class="home-blog-item">
                                        <div class="home-blog-item-image">
                                            <a href="<?php echo get_permalink($blog->ID); ?>">
                                                <img
                                                    class="lazyload"
                                                    src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                                    data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
                                                    alt="<?php echo $blog->post_title; ?>">
                                            </a>
                                        </div>
                                        <div class="home-blog-item-meta-row">
                                            <div class="home-blog-item-category-list">
                                                <?php
                                                    $category_list = get_the_category($blog->ID);

                                                    foreach( $category_list as $category ){
                                                ?>
                                                        <div class="home-blog-item-category-col"><a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="home-blog-item-date"><?php echo get_the_date('j', $blog->ID); ?> <?php echo $greek_month_list[get_the_date('n', $blog->ID) - 1]; ?> <?php echo get_the_date('Y', $blog->ID); ?></div>
                                        </div>
                                        <div class="home-blog-item-title">
                                            <h3><a href="<?php echo get_permalink($blog->ID); ?>"><?php echo $blog->post_title; ?></a></h3>
                                        </div>
                                        <div class="home-blog-item-bottom-row">
                                        <?php if(get_field('event_from_date', $blog->ID)) { ?>
                                            <div class="home-blog-item-bottom-left-col">
                                                <div class="home-blog-item-duration-row">
                                                    <div class="home-blog-item-duration-col">
                                                        <div class="home-blog-item-duration-label">ΑΠΟ</div>
                                                        <div class="home-blog-item-duration-date"><?php echo get_field('event_from_date', $blog->ID); ?></div>
                                                    </div>
                                                    <div class="home-blog-item-duration-col">
                                                        <div class="home-blog-item-duration-label">ΕΩΣ</div>
                                                        <div class="home-blog-item-duration-date"><?php echo get_field('event_to_date', $blog->ID); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?> 
                                            <div class="home-blog-item-bottom-right-col">
                                                <div class="home-blog-item-excerpt">
                                                <?php echo get_field('post_lead', $blog->ID); ?>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="home-blog-slider-nav-wrapper">
                    <div data-slider-button="prev" class="home-blog-slider-nav home-blog-slider-nav--prev"><?php include get_template_directory() . '/assets/icons/slider-prev-icon.svg'; ?></div>
                    <div data-slider-button="next" class="home-blog-slider-nav home-blog-slider-nav--next"><?php include get_template_directory() . '/assets/icons/slider-next-icon.svg'; ?></div>
                </div>
            </div>
        </div>
    </div>
</section>