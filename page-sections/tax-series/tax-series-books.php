<?php
    global $post;

    $current_series_taxonomy = get_queried_object();

    $productPerPage = 16;

    if( wp_is_mobile() ){
        $productPerPage = 4;
    }
    
    $page = 1;

    // get all products that has selected series taxonomy
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $productPerPage,
        'offset' => ( $page - 1 ) * $productPerPage,
        'tax_query' => [
            [
                'taxonomy' => 'series',
                'field' => 'term_id',
                'terms' => $current_series_taxonomy->term_id
            ],
        ],
        'meta_key' => 'book_first_published_date',
        'orderby' => 'meta_value',
        'order' => 'desc',
        'fields' => 'ids'
    ];

    $the_query = new WP_Query( $args );

    if ( !empty($the_query->posts) ) {
        $products_search_count = $the_query->found_posts;
?>
        <section id="js-tax-series-books" class="pcat-results-section pcat-results-section--border-top">
            <div class="general-container">
                <div class="content-container">
                    <div class="pcat-results-top-title">
                        <h2>TA ΒΙΒΛΙΑ ΤΗΣ ΣΕΙΡΑΣ</h2>
                    </div>
                    <div class="pcat-results-top-row">
                        <div class="pcat-results-top-left-col">
                            <div class="pcat-results-title">
                                <h2>ΤΙΤΛΟΙ: <?php echo $products_search_count; ?></h2>
                            </div>
                        </div>
                        <div class="pcat-results-top-right-col">
                            <div class="pcat-classification-filter">
                                <div class="pcat-classification-filter-label pcat-classification-filter-label--black">ΤΑΞΙΝΟΜΗΣΗ</div>
                                <div class="pcat-classification-filter-select">
                                    <select id="js-ts-product-display-order">
                                        <option value="published-date">Ημερ/νια Έκδοσης</option>
                                        <option value="alphabetical">Αλφαβητικά</option>
                                    </select>
                                    <div class="pcat-classification-filter-select-icon"><?php include get_template_directory() . '/assets/icons/arrow-down-white-icon.svg'; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="js-taxonomy-series-product-row" class="pcat-results-row" data-nonce="<?php echo wp_create_nonce('filter_taxonomy_series_product_nonce'); ?>" data-product-per-page="<?php echo $productPerPage; ?>" data-series-term-id="<?php echo $current_series_taxonomy->term_id; ?>">
                        <?php
                            foreach( $the_query->posts as $postid ) {
                        ?>
                                <div class="pcat-results-col">
                                    <?php get_template_part('product/loop/loop', 'product-card', [ 'postId' => $postid ]); ?>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                    <?php
                        if( $products_search_count > $productPerPage ){
                            get_template_part('product/page-nav/page-nav', 'navigation', [ 
                                'navWrapperDomId' => "js-taxonomy-series-product-navigation",
                                'navDomClass' => "js-ts-product-navigation-item",
                                'gotoDomId' => "js-ts-products-page-list",
                                'total' => $products_search_count,
                                'perPage' => $productPerPage
                            ]);
                        }
                    ?>
                </div>
            </div>
        </section>
<?php
    }
?>