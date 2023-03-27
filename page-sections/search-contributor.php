<?php
    global $post;
    $searchKey = get_search_query();

    $the_query = new WP_Query([
        'post_type' => 'contributor',
        'posts_per_page' => -1,
        // 's' => $searchKey
        'search_prod_title' => $searchKey,
        'post_status' => 'publish',
    ]);
?>
<section class="search-result-category-section">
    <div class="general-container">
        <div class="content-container">
            <div class="search-result-category-title">
                <h2>ΣΥΝΤΕΛΕΣΤΕΣ: <?php echo $the_query->found_posts; ?></h2>
            </div>
            <?php
                if ( $the_query->have_posts() ) {
            ?>
                    <div class="search-result-category-list">
                        <?php
                            while ( $the_query->have_posts() ) {
                                $the_query->the_post();
                        ?>
                                <div class="search-result-category-item">
                                    <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
            <?php
                }

                wp_reset_postdata();
            ?>
        </div>
    </div>
</section>