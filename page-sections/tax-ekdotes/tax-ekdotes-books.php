<?php
    $current_ekdotes_taxonomy = get_queried_object();
    //global $post;

    $productPerPage = 16;

    if( wp_is_mobile() ){
        $productPerPage = 4;
    }

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $productOrder = isset($_GET['productOrder']) ? $_GET['productOrder'] : 'published-date';
    // get book that this single publisher was included
    //$current_single_publisher_id = $post->ID;

    // get all products that has this single publiser
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $productPerPage,
        'offset' => ($page - 1) * $productPerPage,
        'post_status' => 'publish',
        //'meta_query' => [
		//	[
		//		'key'     => 'book_publishers',
		//		'value'   => '"' . $current_single_publisher_id . '"',
		//		'compare' => 'LIKE'
        //    ],
        //],
        'tax_query' => array(
            array(
                'taxonomy' => 'ekdotes',
                'field' => 'id',
                'terms' => $current_ekdotes_taxonomy->term_id,
            )
        ),     
        'fields' => 'ids'
    ];

    if( $productOrder === 'alphabetical' ){
        $args['orderby'] = 'title';
        $args['order'] = 'asc';
    } else if( $productOrder === 'published-date' ){
        $args['meta_key'] = 'book_first_published_date';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'desc';
    }

    $the_query = new WP_Query( $args );

    if ( !empty($the_query->posts) ) {
        $count_product_list_include_single_publisher = $the_query->found_posts;
?>
        <section id="js-single-publisher-book-list-section" class="pcat-results-section">
            <div class="general-container">
                <div class="content-container">
                    <div class="pcat-results-top-title">
                        <h2>ΒΙΒΛΙΑ</h2>
                    </div>
                    <div class="pcat-results-top-row">
                        <div class="pcat-results-top-left-col">
                            <div class="pcat-results-title">
                                <h2>ΤΙΤΛΟΙ: <?php echo $count_product_list_include_single_publisher; ?></h2>
                            </div>
                        </div>
                        <div class="pcat-results-top-right-col">
                            <div class="pcat-classification-filter">
                                <div class="pcat-classification-filter-label pcat-classification-filter-label--black">ΤΑΞΙΝΟΜΗΣΗ</div>
                                <div class="pcat-classification-filter-select">
                                    <select id="js-sp-product-display-order">
                                        <option value="published-date" <?php echo $productOrder === 'published-date' ? 'selected' : '' ?>>Ημερ/νια Έκδοσης</option>
                                        <option value="alphabetical" <?php echo $productOrder === 'alphabetical' ? 'selected' : '' ?>>Αλφαβητικά</option>
                                    </select>
                                    <div class="pcat-classification-filter-select-icon"><?php include get_template_directory() . '/assets/icons/arrow-down-white-icon.svg'; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="js-single-publisher-product-row" class="pcat-results-row" data-nonce="<?php echo wp_create_nonce('filter_single_publisher_product_nonce'); ?>" data-product-per-page="<?php echo $productPerPage; ?>" data-publisher-id="<?php echo $current_ekdotes_taxonomy->term_id; ?>">
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
                        if( $count_product_list_include_single_publisher > $productPerPage ){
                            get_template_part('product/page-nav/page-nav', 'navigation', [ 
                                'navWrapperDomId' => "js-single-publisher-product-navigation",
                                'navDomClass' => "js-sp-product-navigation-item",
                                'gotoDomId' => "js-sp-page-list",
                                'total' => $count_product_list_include_single_publisher,
                                'perPage' => $productPerPage,
                                'currentPage' => $page,
                            ]);
                        }
                    ?>
                </div>
            </div>
        </section>
<?php
    }
?>