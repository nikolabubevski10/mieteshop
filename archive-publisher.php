<?php
    global $post;

    get_header();
?>
<section class="archive-publisher-title">
    <div class="general-container">
        <div class="content-container">
            <h1>Εκδόσεις Άλλων Φορέων</h1>
        </div>
    </div>
</section>
<section class="archive-publisher-month-section">
    <div class="content-container">
        <div class="archive-publisher-month-title">
            <h2>ΟΙ ΦΟΡΕΙΣ ΤΟΥ ΜΗΝΑ</h2>
        </div>
        <div class="archive-publisher-month-row">
            <?php
                $args = [
                    'post_type' => 'publisher',
                    'posts_per_page' => 6,
                ];
            
                $loop = new WP_Query( $args );

                while ( $loop->have_posts() ){
                    $loop->the_post();

                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            ?>
                    <div class="archive-publisher-month-col">
                        <div class="archive-publisher-month-item">
                            <div class="archive-publisher-month-image">
                                <img
                                    class="lazyload"
                                    src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                    data-src="<?php echo aq_resize($image[0], 180, 180, true); ?>"
                                    alt="<?php echo $post->post_title; ?>">
                            </div>
                            <div class="archive-publisher-month-title">
                                <h3><?php echo $post->post_title; ?></h3>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
        <div class="archive-publisher-mobile-slider" is="mieteshop-home-authors-mobile-slider">
            <div class="swiper-container" data-slider>
                <div class="swiper-wrapper">
                    <?php
                        while ( $loop->have_posts() ){
                            $loop->the_post();

                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                    ?>
                            <div class="swiper-slide">
                                <div class="archive-publisher-month-col">
                                    <div class="archive-publisher-month-item">
                                        <div class="archive-publisher-month-image">
                                            <img
                                                class="lazyload"
                                                src="<?php echo placeholderImage($image[1], $image[2]); ?>"
                                                data-src="<?php echo aq_resize($image[0], 180, 180, true); ?>"
                                                alt="<?php echo $post->post_title; ?>">
                                        </div>
                                        <div class="archive-publisher-month-title">
                                            <h3><?php echo $post->post_title; ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="archive-publisher-mobile-slider-nav-wrapper">
                    <div data-slider-button="prev" class="archive-publisher-mobile-slider-nav archive-publisher-mobile-slider-nav--prev"><?php include get_template_directory() . '/assets/icons/slider-prev-white-icon.svg'; ?></div>
                    <div data-slider-button="next" class="archive-publisher-mobile-slider-nav archive-publisher-mobile-slider-nav--next"><?php include get_template_directory() . '/assets/icons/slider-next-white-icon.svg'; ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="archive-publisher-search-section">
    <div class="general-container">
        <div class="content-container">
            <div class="archive-publisher-search-title">
                <h2>ΕΥΡΕΤΗΡΙΟ ΕΚΔΟΤΩΝ</h2>
            </div>
            <div class="archive-publisher-search-greek-letter-wrapper">
                <div class="archive-publisher-search-greek-letter-row">
                    <?php
                        $greek_letter_list = ['α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ','o','π','ρ','σ','τ','υ','φ','χ','ψ','ω'];
                        for($i = 0; $i < 24; $i++){
                    ?>
                            <div class="archive-publisher-search-greek-letter-col js-archive-publisher-search-greek-letter-col <?php echo $i == 0 ? 'active' : ''; ?>"><?php echo $greek_letter_list[$i]; ?></div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="archive-publisher-search-english-letter-wrapper">
                <div class="archive-publisher-search-english-letter-row">
                    <?php
                        $english_letter_list = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

                        for($i = 0; $i < 26; $i++){
                    ?>
                            <div class="archive-publisher-search-english-letter-col js-archive-publisher-search-english-letter-col"><?php echo $english_letter_list[$i]; ?></div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <div class="archive-publisher-search-type-row">
                <?php
                    $taxonomies = get_terms([
                        'taxonomy' => 'publisher_type',
                        'hide_empty' => false
                    ]);

                    foreach($taxonomies as $term){
                ?>
                        <div class="archive-publisher-search-type-col">
                            <label><?php echo $term->name; ?><input type="checkbox" class="js-archive-publisher-search-type-col" value="<?php echo $term->term_id; ?>"><span></span></label>
                        </div>
                <?php
                    }
                ?>
            </div>
            <div id="js-archive-publisher-search-result-list" class="archive-publisher-search-result-list" data-nonce="<?php echo wp_create_nonce('filter_search_archive_publisher_nonce'); ?>">
                <?php
                    $publisher_term_list = get_terms([
                        'taxonomy' => 'ekdotes', 
                        'posts_per_page' => -1,
                        'search_title_with_first_letter' => 'α',
                        'hide_empty' => true, 
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ]);

                    foreach($publisher_term_list as $term){
                ?>
                        <div class="archive-publisher-search-result-col"><a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a></div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<div id="js-archive-publisher__load-spinner" class="load-spinner hide"></div>

<?php get_footer(); ?>
