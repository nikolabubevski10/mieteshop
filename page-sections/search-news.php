<?php
    global $post;
    $searchKey = get_search_query();
    $posts_per_page = 8;

    $current_page = 1;

    $args = [
        'post_type' => 'post',
        'search_prod_title' => $searchKey,
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'desc'
    ];

    $the_query = new WP_Query( $args );

    // get total search result count
    $total_post_count = $the_query->found_posts;
?>
    <section class="search-result-category-section">
        <div class="general-container">
            <div class="content-container">
                <div class="pcat-results-title">
                    <h2>ΝΕΑ: <?php echo $total_post_count; ?></h2>
                </div>
            </div>
            <?php
                if ( $the_query->have_posts() ) {
            ?>
                    <div class="small-container">
                        <div id="js-search-news__results-row" class="blog-result-row" data-nonce="<?php echo wp_create_nonce('filter_search_news_nonce'); ?>" data-search-key="<?php echo $searchKey; ?>">
                            <?php
                                while ( $the_query->have_posts() ){
                                    $the_query->the_post();
                                    get_template_part('post/loop/loop', 'post-card', [ 'postId' => $post->ID ]);
                                }
                            ?>
                        </div>
                        <?php
                            if( $total_post_count > $posts_per_page ){
                                get_template_part('product/page-nav/page-nav', 'navigation', [ 
                                    'navWrapperDomId' => "js-search-news__results-navigation",
                                    'navDomClass' => "js-search-news__results-navigation-item",
                                    'gotoDomId' => "js-search-news__page-list",
                                    'total' => $total_post_count,
                                    'perPage' => $posts_per_page
                                ]);
                            }
                        ?>
                    </div>
            <?php
                }
            ?>
        </div>
    </section>
<div id="js-search-news__load-spinner" class="load-spinner hide"></div>