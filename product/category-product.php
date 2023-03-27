<?php
    global $wp_query, $post;

    // get term of current product category page
    $product_cat = $wp_query->get_queried_object();

    // get parent list of term
    $product_cat_parent_list = array_reverse(get_ancestors($product_cat->term_id, 'product_cat'));

    // get level of term
    $product_cat_level = count($product_cat_parent_list) + 1;

    $child_cat_list = get_terms([
        'taxonomy' => 'product_cat', 
        'hide_empty' => false, 
        // 'child_of' => $product_cat->term_id,
        'parent' => $product_cat->term_id,
    ]);

    $filterTermIdsStr = isset($_GET['filterTermIds']) ? $_GET['filterTermIds'] : '';

    $filterTermIds = $filterTermIdsStr === '' ? [] : array_map('intval', explode(',', $filterTermIdsStr));
    $selectedCatList = [];
    $filterAuthorId = isset($_GET['filterAuthorId']) ? intval($_GET['filterAuthorId']) : null;
    $filterPublisherId = isset($_GET['filterPublisherId']) ? intval($_GET['filterPublisherId']) : null;
    $mainProductCatId = isset($_GET['mainProductCatId']) ? intval($_GET['mainProductCatId']) : 1;


    $product_per_page = 16;

    if( wp_is_mobile() ){
        $product_per_page = 4;
    }

    $product_per_page = isset($_GET['productPerPage']) ? intval($_GET['productPerPage']) : $product_per_page;
    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $productOrder = isset($_GET['productOrder']) ? $_GET['productOrder'] : 'published-date';
?>
<section class="breadcrumb-section">
    <div class="content-container">
        <div class="breadcrumb-list">
            <div class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Βιβλία</a></div>
            <?php
                foreach( $product_cat_parent_list as $parent ){
                    $parent_object = get_term($parent);
            ?>
                    <div class="breadcrumb-item"><a href="<?php echo get_term_link($parent_object->term_id); ?>"><?php echo $parent_object->name; ?></a></div>
            <?php
                }
            ?>
            <div class="breadcrumb-item"><a href="<?php echo get_term_link($product_cat->term_id); ?>"><?php echo $product_cat->name; ?></a></div>
        </div>
    </div>
</section>
<section class="pcat-list-section">
    <div class="content-container">
        <div id="js-pcat-list-title" class="pcat-list-title" data-main-product-cat-id="<?php echo $product_cat->term_id; ?>" data-nonce="<?php echo wp_create_nonce('filter_category_product_nonce'); ?>">
            <h1><?php echo $product_cat->name; ?></h1>
        </div>
        <?php
            if( !empty($child_cat_list) ){
        ?>
                <div class="pcat-list-row">
                    <div class="pcat-list-label">Μετάβαση σε:</div>
                    <div class="pcat-list-col-row">
                        <?php
                            foreach($child_cat_list as $child_cat){
                        ?>
                                <div class="pcat-list-col">
                                    <a href="<?php echo get_term_link($child_cat->term_id); ?>"><?php echo $child_cat->name; ?></a>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
        <?php
            }
        ?>
    </div>
</section>
<?php
    if( $product_cat_level < 3 && !empty($child_cat_list) ){
?>
        <section class="pcat-filter-section">
            <div id="js-pcat-filter-row-wrapper" class="pcat-filter-row-wrapper">
                <div class="content-container">
                    <div class="pcat-filter-row">
                        <div class="pcat-filter-label">
                            <div class="pcat-filter-label-icon"><?php include get_template_directory() . '/assets/icons/filter-icon.svg'; ?></div>
                            <div class="pcat-filter-label-text">ΦΙΛΤΡΑ</div>
                        </div>
                        <div class="pcat-filter-button">
                            <div id="js-pcat-filter-button-inner" class="pcat-filter-button-inner">
                                <div class="pcat-filter-button-label">Επιλέξτε θεματικά φίλτρα</div>
                                <div class="pcat-filter-button-icon">
                                    <div class="pcat-filter-button-icon-inner"><?php include get_template_directory() . '/assets/icons/arrow-down-icon.svg'; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-container">
                <div id="js-pcat-filter-detail-row" class="pcat-filter-detail-row" data-filter-term-list="<?php echo $filterTermIdsStr; ?>" style="display: none;">
                    <?php
                        if( $product_cat_level === 1 ){
                            foreach ($child_cat_list as $child_cat) {
                                $child_cat_class = '';
                                $child_child_cat_class_disable = '';
                                                        
                                if( in_array($child_cat->term_id, $filterTermIds) ){
                                    $child_cat_class = 'active';
                                    $child_child_cat_class_disable = 'disable';
                                    $selectedCatList[] = [
                                        'root_class' => 'pcat-extra-thematic-filter-item--root',
                                        'cat' => $child_cat
                                    ];
                                }
                    ?>
                                <div class="pcat-filter-detail-col">
                                    <?php
                                        $child_child_cat_list = get_terms([
                                            'taxonomy' => 'product_cat', 
                                            'hide_empty' => false, 
                                            // 'child_of' => $child_cat->term_id,
                                            'parent' => $child_cat->term_id,
                                        ]);
                                    ?>
                                    <div class="js-pcat-filter-detail-parent pcat-filter-detail-root <?php echo $child_cat_class; ?>" data-term-id="<?php echo $child_cat->term_id; ?>"><?php echo $child_cat->name; ?>
                                        <?php
                                            if( !empty($child_child_cat_list) ){
                                        ?>
                                                <div class="js-pcat-filter-detail-root-icon pcat-filter-detail-root-icon"><div class="pcat-filter-detail-root-icon-wrapper"><?php include get_template_directory() . '/assets/icons/arrow-down-icon.svg'; ?></div></div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                        if( !empty($child_child_cat_list) ){
                                    ?>
                                            <div class="pcat-filter-detail-child-wrapper">
                                                <?php
                                                    foreach ($child_child_cat_list as $child_child_cat) {
                                                        $child_child_cat_class_active = '';
                                                        
                                                        if( in_array($child_child_cat->term_id, $filterTermIds) ){
                                                            $child_child_cat_class_active = ' active';
                                                            $selectedCatList[] = [
                                                                'root_class' => '',
                                                                'cat' => $child_child_cat
                                                            ];
                                                        }
                                                ?>
                                                        <div class="js-pcat-filter-detail-child pcat-filter-detail-child <?php echo $child_child_cat_class_disable; ?> <?php echo $child_child_cat_class_active; ?>" data-term-id="<?php echo $child_child_cat->term_id; ?>"><?php echo $child_child_cat->name; ?></div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                    <?php
                            }
                        } else if( $product_cat_level === 2 ) {
                    ?>
                            <div class="pcat-filter-detail-col">
                                <?php
                                    foreach ($child_cat_list as $child_cat) {
                                        $child_cat_class = '';
                                                                
                                        if( in_array($child_cat->term_id, $filterTermIds) ){
                                            $child_cat_class = 'active';
                                            $selectedCatList[] = [
                                                'root_class' => 'pcat-extra-thematic-filter-item--root',
                                                'cat' => $child_cat
                                            ];
                                        }
                                ?>
                                        <div class="js-pcat-filter-detail-child pcat-filter-detail-child <?php echo $child_cat_class; ?>" data-term-id="<?php echo $child_cat->term_id; ?>"><?php echo $child_cat->name; ?></div>
                                <?php
                                    }
                                ?>
                            </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </section>
<?php
    }
?>
<div class="pcat-extra-filter-section">
    <div class="content-container">
        <div id="js-pcat-extra-thematic-filter" class="pcat-extra-thematic-filter <?php echo empty($selectedCatList) ? 'hide' : ''; ?>">
            <div id="js-pcat-extra-thematic-filter-title" class="pcat-extra-thematic-filter-title">ΘΕΜΑΤΙΚΑ ΦΙΛΤΡΑ (<span><?php echo count($selectedCatList); ?></span>)</div>
            <div id="js-pcat-extra-thematic-filter-row" class="pcat-extra-thematic-filter-row">
                <?php
                    foreach($selectedCatList as $item){
                ?>
                        <div id="js-pcat-extra-thematic-filter-col-<?php echo $item['cat']->term_id; ?>" class="pcat-extra-thematic-filter-col">
                            <div class="pcat-extra-thematic-filter-item <?php echo $item['root_class']; ?>"><?php echo $item['cat']->name; ?><span data-term-id="<?php echo $item['cat']->term_id; ?>"></span></div>
                        </div>
                <?php
                    }
                ?>
            </div>
            <div class="pcat-extra-thematic-filter-link">
                <a id="js-pcat-extra-thematic-filter-link-clear" href="#">καθαρισμός φίλτρων</a>
            </div>
        </div>
        <div class="pcat-extra-filter-top-row">Επιλέξτε</div>
        <div class="pcat-extra-filter-row">
            <div class="pcat-extra-filter-left-col">
                <div class="pcat-author-publisher-choice-wrapper">
                    <div class="pcat-author-publisher-choice-row">
                        <div class="pcat-author-publisher-choice-col">
                            <div class="pcat-author-publisher-choice-item">
                                <label>Συγγραφέα<input type="radio" name="radio-pcat-author-publisher-choice-item" class="js-pcat-author-publisher-choice-item" value="author" <?php echo empty($filterAuthorId) && !empty($filterPublisherId) ? '' : 'checked'; ?>><span></span></label>
                            </div>
                        </div>
                        <div class="pcat-author-publisher-choice-col">
                            <div class="pcat-author-publisher-choice-item">
                                <label>Εκδότη<input type="radio" name="radio-pcat-author-publisher-choice-item" class="js-pcat-author-publisher-choice-item" value="publisher" <?php echo empty($filterPublisherId) ? '' : 'checked'; ?>><span></span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pcat-author-publisher-select-wrapper">
                    <?php
                        // get all products in current category
                        // this query needs to get all authors and publisher in selected category
                        $args = [
                            'post_type' => 'product',
                            'tax_query' => [
                                [
                                    'taxonomy' => 'product_cat',
                                    'field' => 'term_id',
                                    'terms' => $product_cat->term_id,
                                ],
                            ],
                            'posts_per_page' => -1,
                            'post_status' => 'publish',
                            'fields' => 'ids',
                        ];

                        if( !empty($filterTermIds) ){
                            $args['tax_query'] = [
                                [
                                    'taxonomy' => 'product_cat',
                                    'field' => 'term_id',
                                    'terms' => $filterTermIds
                                ],
                            ];
                        }
                    
                        $the_query = new WP_Query( $args );

                        // get author list that included in search result
                        $author_list_in_search_result = [];

                        // get publisher terms that included in search result
                        $publisher_terms_in_search_result = [];
                    
                        if ( !empty($the_query->posts) ) {
                            foreach( $the_query->posts as $postid ) {
                                // get author & publisher list that include in the search result
                                $authorIDs = get_field('book_contributors_syggrafeas', $postid);

                                if( !empty($authorIDs) ){
                                    foreach($authorIDs as $authorID){
                                        $author_list_in_search_result[$authorID] = get_the_title($authorID);
                                    }
                                }

                                $publisher_terms = get_the_terms( $postid, 'ekdotes' );

                                if( !empty($publisher_terms) ){
                                    foreach( $publisher_terms as $term ) { 
                                        $publisher_terms_in_search_result[$term->term_id] = $term->name; 
                                    }
                                }
                            }

                            // sort array by value
                            
                            asort($author_list_in_search_result);
                            //asort($publisher_terms_in_search_result);                            
                            //change by Daphne to sort accented greek characters in publishers list correctly 
                            //the Collator PHP class provides string comparison capability with support for appropriate locale-sensitive sort orderings.
                            $collator = Collator::create('el_GR.utf8');
                            $collator->asort($publisher_terms_in_search_result); //use asort to maintain index association
                            //echo '<pre>'; var_dump($publisher_terms_in_search_result); echo '</pre>';


                        }
                    ?>
                    <div id="js-pcat-author-list-wrapper" class="pcat-author-publisher-select pcat-author-publisher-select--large <?php echo empty($filterAuthorId) && !empty($filterPublisherId) ? 'hide' : ''; ?>">
                        <select id="js-pcat-author-list" style="width:100%;">
                            <option></option>
                            <?php
                                foreach($author_list_in_search_result as $author_id => $author_title){
                            ?>
                                    <option value="<?php echo $author_id; ?>" <?php echo $author_id === $filterAuthorId ? 'selected' : ''; ?>><?php echo $author_title; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div id="js-pcat-publisher-list-wrapper" class="pcat-author-publisher-select pcat-author-publisher-select--large <?php echo empty($filterPublisherId) ? 'hide' : ''; ?>">
                        <select id="js-pcat-publisher-list" style="width:100%;">
                            <option></option>
                            <?php
                                foreach($publisher_terms_in_search_result as $publisher_id => $publisher_title){
                            ?>
                                    <option value="<?php echo $publisher_id; ?>" <?php echo $publisher_id === $filterPublisherId ? 'selected' : ''; ?>><?php echo $publisher_title; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="pcat-extra-filter-right-col">
                <div class="pcat-classification-filter">
                    <div class="pcat-classification-filter-label">ΤΑΞΙΝΟΜΗΣΗ</div>
                    <div class="pcat-classification-filter-select" id="js-pcat-product-display-order">
                        <select >
                            <option value="published-date" <?php echo $productOrder === 'published-date' ? 'selected' : '' ?>>Ημερ/νια Έκδοσης</option>
                            <option value="alphabetical" <?php echo $productOrder === 'alphabetical' ? 'selected' : '' ?>>Αλφαβητικά</option>
                        </select>
                        <!--div class="pcat-classification-filter-select-icon"><?php //include get_template_directory() . '/assets/icons/arrow-down-white-icon.svg'; ?></div-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    // get products of selected category by page
    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',        
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $product_cat->term_id,
            ],
        ],
        'posts_per_page' => $product_per_page,
        'offset' => ( $current_page - 1 ) * $product_per_page,
        'fields' => 'ids'
    ];

    if( !empty($filterTermIds) ){
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $filterTermIds
            ],
        ];
    }

    if( $productOrder === 'alphabetical' ){
        $args['orderby'] = 'title';
        $args['order'] = 'asc';
    } else if( $productOrder === 'published-date' ){
        $args['meta_key'] = 'book_first_published_date';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'desc';
    }

    if( !empty($filterAuthorId) ){
        $args['meta_query'] = [
			[
				'key'     => 'book_contributors_syggrafeas',
				'value'   => '"' . $filterAuthorId . '"',
				'compare' => 'LIKE'
            ],
        ];
    }

    if( !empty($filterPublisherId) ){
        $args['tax_query'][] = [
            'taxonomy'     => 'ekdotes',
            'terms'   => $filterPublisherId,
        ];
    }

    $the_query = new WP_Query( $args );

    if ( !empty($the_query->posts) ) {
        // get total search result count
        $total_product_count = $the_query->found_posts;
?>
        <section id="js-pcat-results-section" class="pcat-results-section">
            <div class="general-container">
                <div class="content-container">
                    <div class="pcat-results-title">
                        <h2>ΤΙΤΛΟΙ: <span id="js-pcat-results-count"><?php echo $total_product_count; ?></span></h2>
                    </div>
                    <div id="js-pcat-results-row" class="pcat-results-row">
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
                        get_template_part('product/page-nav/page-nav', 'navigation', [ 
                            'navWrapperDomId' => "js-pcat-results-navigation",
                            'navDomClass' => "js-pcat-results-navigation-item",
                            'gotoDomId' => "js-pcat-products-page-list",
                            'total' => $total_product_count,
                            'perPage' => $product_per_page,
                            'currentPage' => $current_page,
                        ]);

                        get_template_part('product/page-nav/page-nav', 'per-page', [ 
                            'selectDomId' => "js-pcat-products-per-page",
                            'perPage' => $product_per_page,
                        ]);
                    ?>
                </div>
            </div>
        </section>
<?php
    }
?>
<div id="js-category-product-filter-load-spinner" class="load-spinner hide"></div>