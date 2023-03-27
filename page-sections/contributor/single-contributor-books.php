<?php
    global $post;

    $productPerPage = 16;

    if( wp_is_mobile() ){
        $productPerPage = 4;
    }

    $page = 1;
?>
<section id="js-single-contributor-books" class="single-product-recently-section single-product-recently-section--border-bottom">
    <div class="content-container">
        <div class="single-product-recently-title">
            <h2>ΒΙΒΛΙΑ ΤΟΥ ΣΥΓΓΡΑΦΕΑ</h2>
        </div>
        <div id="js-single-contributor-product-row" class="pcat-results-row" data-nonce="<?php echo wp_create_nonce('filter_single_contributor_product_nonce'); ?>" data-product-per-page="<?php echo $productPerPage; ?>" data-contributor-id="<?php echo $post->ID; ?>">
            <?php
                $args = [
                    'post_type' => 'product',
                    'posts_per_page' => $productPerPage,
                    'offset' => ($page - 1) * $productPerPage,
                    'meta_query' => [
                        [
                            'key'     => 'book_contributors_syggrafeas',
                            'value'   => '"' . $post->ID . '"',
                            'compare' => 'LIKE'
                        ],
                    ],
                    'meta_key' => 'book_first_published_date',
                    'orderby' => 'meta_value',
                    'order' => 'desc',
                    'fields' => 'ids'
                ];

                $loop = new WP_Query( $args );

                $count_product_list_include_single_contributor = $loop->found_posts;

                foreach ( $loop->posts as $postid ){
            ?>
                    <div class="pcat-results-col">
                        <?php get_template_part('product/loop/loop', 'product-card', [ 'postId' => $postid ]); ?>
                    </div>
            <?php
                }
            ?>
        </div>
        <?php
            if( $count_product_list_include_single_contributor > $productPerPage ){
                get_template_part('product/page-nav/page-nav', 'navigation', [ 
                    'navWrapperDomId' => "js-single-contributor-product-navigation",
                    'navDomClass' => "js-sc-product-navigation-item",
                    'gotoDomId' => "js-sc-page-list",
                    'total' => $count_product_list_include_single_contributor,
                    'perPage' => $productPerPage
                ]);
            }
        ?>
    </div>
</section>