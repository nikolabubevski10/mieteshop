<?php
    global $post;
    $searchKey = get_search_query();
    $product_per_page = 16;

    if( wp_is_mobile() ){
        //$product_per_page = 4; //commented it out on 15/2/2023 to fix bug with fewer results in filter in mobile
    }

    $current_page = 1;

    /*
    // get all products in current search key
    $args = [
        'post_type' => 'product',
        // 'search_prod_title' => $searchKey,
        'search_prod_title_sub_title' => $searchKey,
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'title_type',
                'field' => 'slug',
                'terms' => 'book',
            ]
        ],
        'fields' => 'ids',
        'post_status' => 'publish',
        'meta_query' => [
            'relation' => 'AND',
            'book_subtitle_clause' => [
                'key' => 'book_subtitle',
                'compare' => 'EXISTS',
            ],
            'book_first_published_date_clause' => [
                'key' => 'book_first_published_date',
                'compare' => 'EXISTS',
            ]
        ],
        'orderby' => [
            'book_first_published_date_clause' => 'DESC',
        ]
        // Need to add this so query_posts joins the postmeta table in the query. 
        // 'meta_key' => 'book_first_published_date',
        // 'orderby' => 'meta_value',
        // 'order' => 'desc',
        // Need to add this so query_posts joins the postmeta table in the query. 
        // Above I overwrite the where bit and use meta. Via title_sub_title_filter()
        // 'meta_query' => [['key' => '', 'value' => '', 'compare' => '', 'type' => '']]
    ];

    */

    /* ----------------------------------------------------------------------------------------- */
    //--- 1st query to get book ids that have search string in title or subtitle 
    $args1 = [
        'post_type' => 'product',
        'search_prod_title_sub_title' => $searchKey, //overwrite the where bit and use meta. Via title_sub_title_filter (inside header-top-search-fucntion.php)
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => [
            [
                'taxonomy' => 'title_type',
                'field' => 'slug',
                'terms' => 'book',
            ]
        ],
        'fields' => 'ids',
        'post_status' => 'publish',
        'meta_query' => [
            'relation' => 'AND',
            'book_subtitle_clause' => [
                'key' => 'book_subtitle', //book_subtitle not empty
                'compare' => 'EXISTS',
            ],
            'book_first_published_date_clause' => [
                'key' => 'book_first_published_date',
                'compare' => 'EXISTS',
            ]            
        ]
    ];
    $qry_searched_book_ids = new WP_Query( $args1 );
    //echo '$qry_searched_book_ids: ' .$qry_searched_book_ids->post_count.'<br/>';

    //--- 2nd query to get contributor ids that have search string in title 
    $args2 = [
        'post_type' => 'contributor',
        'search_prod_title' => $searchKey, //search only in contributor title
        'fields' => 'ids',
        'post_status' => 'publish',    
    ];
    $qry_searched_contributors_ids = new WP_Query( $args2 );    
    //echo '$qry_searched_contributors_ids: ' .$qry_searched_contributors_ids->post_count.'<br/>';

    if($qry_searched_contributors_ids->post_count > 0) {
        //create meta query for each contributor type and each contributor id to pass to product query and get the related books
        $book_contributor_fields = acf_get_fields('3523'); //3523 is the group id
        $meta_query_arrays['relation'] =  'OR';
        $i = 0;    
        foreach ( $qry_searched_contributors_ids->posts as $contributor_id ) {
        //    foreach ( $book_contributor_fields as $book_contributor_field ) {    
            $meta_query_arrays[$i] = array(                            
                'key'     => 'book_contributors_syggrafeas', //$book_contributor_field,
                'value'   => '"' . $contributor_id .'"', //'%"' . $contributor_id .'"%',
                'compare' => 'LIKE'
            ); 
            $i++;  
        //    } 
        } 

        //--- 3rd query to get product ids of specific contributors queried above
        $args3 = [
            'post_type' => 'product',
            'posts_per_page'	=> -1,
            'fields' => 'ids',
            'post_status' => 'publish',        
            'meta_query' => $meta_query_arrays
        ];
        $qry_searched_contributors_book_ids = new WP_Query( $args3 );
        //echo '$qry_searched_contributors_book_ids: ' .$qry_searched_contributors_book_ids->post_count.'<br/>';

        $merged_book_ids_queries = new WP_Query();
        $merged_book_ids_queries->posts = array_merge( $qry_searched_book_ids->posts, $qry_searched_contributors_book_ids->posts ); //combine queries
        $uniquebookids = array_unique($merged_book_ids_queries->posts); //remove duplicate post ids
        //echo '$uniquebookids: ' .count($uniquebookids).'<br/>';
    } else {
        $uniquebookids = $qry_searched_book_ids->posts;
        //echo '$uniquebookids: ' .count($uniquebookids).'<br/>';
    }

    if(count($uniquebookids) > 0) {
        //--- FINAL query to get products of specific ids of above queries 
        $args = [
            'post_type' => 'product',
            'post__in' => $uniquebookids, 
            'posts_per_page' => $product_per_page,
            'offset' => ( $current_page - 1 ) * $product_per_page,
            'tax_query' => [
                [
                    'taxonomy' => 'title_type',
                    'field' => 'slug',
                    'terms' => 'book',
                ]
            ],
            'fields' => 'ids',
            'post_status' => 'publish',
            'meta_query' => [
                'book_first_published_date_clause' => [
                    'key' => 'book_first_published_date',
                    'compare' => 'EXISTS',
                ]
            ],
            'orderby' => [
                'book_first_published_date_clause' => 'DESC',
            ]
        ];

        //$the_query = new WP_Query( $args );    
        /* ----------------------------------------------------------------------------------------- */

        $the_query = new WP_Query( $args );
        //echo '$the_query: ' .$the_query->post_count.'<br/>';

        // get total search result count
        $total_product_count = $the_query->found_posts;
    } else {
        $the_query = [];
        $total_product_count = 0;
    }
    // get author list that included in search result
    $author_list_in_search_result = [];

    // get publisher list that included in search result
    $publisher_list_in_search_result = [];

    // get product category list that included in search result
    $product_category_list_in_search_result = [];

    if ( !empty($the_query->posts) ) {
        foreach( $the_query->posts as $postid ) {
            // get author & publisher & product category list that include in the search result
            $authorIDs = get_field('book_contributors_syggrafeas', $postid);
            $publisher_categories = wp_get_post_terms($postid, 'ekdotes', ['fields' => 'id=>name']);
            $prorudct_categories = wp_get_post_terms($postid, 'product_cat', ['fields' => 'id=>name']);

            if( !empty($authorIDs) ){
                foreach($authorIDs as $authorID){
                    $author_list_in_search_result[$authorID] = get_the_title($authorID);
                }
            }

            if( !empty($publisher_categories) ){
                foreach($publisher_categories as $term_id => $term_name){
                    $publisher_list_in_search_result[$term_id] = $term_name;
                }
            }

            if( !empty($prorudct_categories) ){
                foreach($prorudct_categories as $term_id => $term_name){
                    $product_category_list_in_search_result[$term_id] = $term_name;
                }
            }
        }

        // sort array by value
        asort($author_list_in_search_result);
        asort($publisher_list_in_search_result);
        asort($product_category_list_in_search_result);
    }
?>
<section class="search-page-filter-options-section">
    <div class="search-page-extra-filter-row">
        <div class="search-page-extra-filter-left">
            <div class="pcat-author-publisher-label pcat-author-publisher-label--black">Για να περιορίσετε τα αποτελέσματα επιλέξτε Θεματική ή Συγγραφέα  ή Εκδότη</div>
            <div class="pcat-author-publisher-row">
                <div class="pcat-author-publisher-col">
                    <div class="pcat-author-publisher-select">
                        <select id="js-search-book__product-category-list" style="width:100%;">
                            <option></option>
                            <?php
                                foreach($product_category_list_in_search_result as $cat_id => $cat_title){
                            ?>
                                    <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="pcat-author-publisher-col">
                    <div class="pcat-author-publisher-select">
                        <select id="js-search-book__author-list" style="width:100%;">
                            <option></option>
                            <?php
                                foreach($author_list_in_search_result as $author_id => $author_title){
                            ?>
                                    <option value="<?php echo $author_id; ?>"><?php echo $author_title; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="pcat-author-publisher-col">
                    <div class="pcat-author-publisher-select">
                        <select id="js-search-book__publisher-list" style="width:100%;">
                            <option></option>
                            <?php
                                foreach($publisher_list_in_search_result as $publisher_id => $publisher_title){
                            ?>
                                    <option value="<?php echo $publisher_id; ?>"><?php echo $publisher_title; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-page-extra-filter-right">
            <div class="pcat-classification-filter">
                <div class="pcat-classification-filter-label pcat-classification-filter-label--black">ΤΑΞΙΝΟΜΗΣΗ</div>
                <div class="pcat-classification-filter-select">
                    <select id="js-search-book__display-order">
                        <option value="published-date">Ημερ/νια Έκδοσης</option>
                        <option value="alphabetical">Αλφαβητικά</option>
                    </select>
                    <div class="pcat-classification-filter-select-icon"><?php include get_template_directory() . '/assets/icons/arrow-down-white-icon.svg'; ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
/*
    $args = [
        'post_type' => 'product',
        // 'search_prod_title' => $searchKey,
        'search_prod_title_sub_title' => $searchKey,
        'posts_per_page' => $product_per_page,
        'offset' => ( $current_page - 1 ) * $product_per_page,
        'tax_query' => [
            [
                'taxonomy' => 'title_type',
                'field' => 'slug',
                'terms' => 'book',
            ]
        ],
        'fields' => 'ids',
        'post_status' => 'publish',
        'meta_query' => [
            'relation' => 'AND',
            'book_subtitle_clause' => [
                'key' => 'book_subtitle',
                'compare' => 'EXISTS',
            ],
            'book_first_published_date_clause' => [
                'key' => 'book_first_published_date',
                'compare' => 'EXISTS',
            ]
        ],
        'orderby' => [
            'book_first_published_date_clause' => 'DESC',
        ]
        // Need to add this so query_posts joins the postmeta table in the query. 
        // 'meta_key' => 'book_first_published_date',
        // 'orderby' => 'meta_value',
        // 'order' => 'desc',
        // Need to add this so query_posts joins the postmeta table in the query. 
        // Above I overwrite the where bit and use meta. Via title_sub_title_filter()
        // 'meta_query' => [['key' => '', 'value' => '', 'compare' => '', 'type' => '']]
    ];
*/
    /* ----------------------------------------------------------------------------------------- */
    //--- 1st query to get book ids that have search string in title or subtitle 
    $args1 = [
        'post_type' => 'product',
        'search_prod_title_sub_title' => $searchKey, //overwrite the where bit and use meta. Via title_sub_title_filter (inside header-top-search-fucntion.php)
        'numberposts'	=> -1,
        'fields' => 'ids',
        'tax_query' => [
            [
                'taxonomy' => 'title_type',
                'field' => 'slug',
                'terms' => 'book',
            ]
        ],
        'fields' => 'ids',
        'post_status' => 'publish',
        'meta_query' => [
            'relation' => 'AND',
            'book_subtitle_clause' => [
                'key' => 'book_subtitle', //book_subtitle not empty
                'compare' => 'EXISTS',
            ],
        ]
    ];
    $qry_searched_book_ids = new WP_Query( $args1 );
    //echo '$qry_searched_book_ids: ' .$qry_searched_book_ids->post_count.'<br/>';

    //--- 2nd query to get contributor ids that have search string in title 
    $args2 = [
        'post_type' => 'contributor',
        'search_prod_title' => $searchKey, //search only in contributor title
        'fields' => 'ids',
        'post_status' => 'publish',    
    ];
    $qry_searched_contributors_ids = new WP_Query( $args2 );    
   //echo '$qry_searched_contributors_ids: ' .$qry_searched_contributors_ids->post_count.'<br/>';

    if($qry_searched_contributors_ids->post_count > 0) {
        //create meta query for each contributor type and each contributor id to pass to product query and get the related books
        $book_contributor_fields = acf_get_fields('3523'); //3523 is the group id
        $meta_query_arrays['relation'] =  'OR';
        $i = 0;    
        foreach ( $qry_searched_contributors_ids->posts as $contributor_id ) {
        //    foreach ( $book_contributor_fields as $book_contributor_field ) {    
            $meta_query_arrays[$i] = array(                            
                'key'     => 'book_contributors_syggrafeas', //$book_contributor_field,
                'value'   => '"' . $contributor_id .'"', //'%"' . $contributor_id .'"%',
                'compare' => 'LIKE'
            ); 
            $i++;  
        //    } 
        } 

        //--- 3rd query to get product ids of specific contributors queried above
        $args3 = [
            'post_type' => 'product',
            'numberposts'	=> -1,
            'fields' => 'ids',
            'post_status' => 'publish',        
            'meta_query' => $meta_query_arrays
        ];
        $qry_searched_contributors_book_ids = new WP_Query( $args3 );
        //echo '$qry_searched_contributors_book_ids: ' .$qry_searched_contributors_book_ids->post_count.'<br/>';

        $merged_book_ids_queries = new WP_Query();
        $merged_book_ids_queries->posts = array_merge( $qry_searched_book_ids->posts, $qry_searched_contributors_book_ids->posts ); //combine queries
        $uniquebookids = array_unique($merged_book_ids_queries->posts); //remove duplicate post ids
        //echo '$uniquebookids: ' .count($uniquebookids).'<br/>';
    } else {
        $uniquebookids = $qry_searched_book_ids->posts;
        //echo '$uniquebookids: ' .count($uniquebookids).'<br/>';        
    }

    if(count($uniquebookids) > 0) {
        //--- FINAL query to get products of specific ids of above queries 
        $args = [
            'post_type' => 'product',
            'post__in' => $uniquebookids, 
            'posts_per_page' => $product_per_page,
            'offset' => ( $current_page - 1 ) * $product_per_page,
            'tax_query' => [
                [
                    'taxonomy' => 'title_type',
                    'field' => 'slug',
                    'terms' => 'book',
                ]
            ],
            'fields' => 'ids',
            'post_status' => 'publish',
            'meta_query' => [
                'book_first_published_date_clause' => [
                    'key' => 'book_first_published_date',
                    'compare' => 'EXISTS',
                ]
            ],
            'orderby' => [
                'book_first_published_date_clause' => 'DESC',
            ]
        ];

        $the_query = new WP_Query( $args );    
    } else {
        $the_query = [];
    }
    /* ----------------------------------------------------------------------------------------- */

?>
<section id="js-search-book__results-section" class="search-result-category-section" data-nonce="<?php echo wp_create_nonce('filter_search_book_nonce'); ?>" data-search-key="<?php echo $searchKey; ?>">
    <div class="general-container">
        <div class="content-container">
            <div class="pcat-results-title">
                <h2>ΤΙΤΛΟΙ: <span id="js-search-book__results-count"><?php echo $total_product_count; ?></span></h2>
            </div>
            <div id="js-search-book__results-row" class="pcat-results-row">
                <?php
                    if ( !empty($the_query->posts) ) {
                        foreach( $the_query->posts as $postid ) {
                ?>
                            <div class="pcat-results-col">
                                <?php get_template_part('product/loop/loop', 'product-card', [ 'postId' => $postid ]); ?>
                            </div>
                <?php
                        }
                    }
                ?>
            </div>
            <?php
                if( $total_product_count > $product_per_page ){

                    get_template_part('product/page-nav/page-nav', 'navigation', [ 
                        'navWrapperDomId' => "js-search-book__results-navigation",
                        'navDomClass' => "js-search-book__results-navigation-item",
                        'gotoDomId' => "js-search-book__page-list",
                        'total' => $total_product_count,
                        'perPage' => $product_per_page
                    ]);
                }

                if ( !empty($the_query->posts) ) {
                    get_template_part('product/page-nav/page-nav', 'per-page', [ 'selectDomId' => "js-search-book__per-page" ]);
                }
            ?>
        </div>
    </div>
</section>
<div id="js-search-book__load-spinner" class="load-spinner hide"></div>