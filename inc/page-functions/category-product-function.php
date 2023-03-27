<?php
add_action('wp_ajax_filter_category_product', 'filterCategoryProduct');
add_action('wp_ajax_nopriv_filter_category_product', 'filterCategoryProduct');

function filterCategoryProduct()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_category_product_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $filterTermIds = $_REQUEST['filterTermIds'];
    $productOrder = $_REQUEST['productOrder'];
    $filterAuthorId = intval($_REQUEST['filterAuthorId']);
    $filterPublisherId = intval($_REQUEST['filterPublisherId']);
    $mainProductCatId = intval($_REQUEST['mainProductCatId']);
    $page = intval($_REQUEST['page']);
    $productPerPage = intval($_REQUEST['productPerPage']);
    $changedSelectedTermIds = $_REQUEST['changedSelectedTermIds'];

    require_once dirname(dirname(__FILE__)) . '/zebra-pagination.php';

    $pagination = new Zebra_Pagination();
    $pagination->records_per_page($productPerPage);
    $pagination->selectable_pages(5);
    $pagination->set_page($page);
    $pagination->padding(false);
    $pagination->css_classes([
        'list' => 'pcat-results-navigation-row',
        'list_item' => 'js-pcat-results-navigation-item pcat-results-navigation-item',
        'prev' => 'js-pcat-results-navigation-item pcat-results-navigation-prev',
        'next' => 'js-pcat-results-navigation-item pcat-results-navigation-next',
        'anchor' => '',
    ]);

    // get author and publisher list of selected category
    // get author list that included in search result
    $author_list_in_search_result = [];

    // get publisher terms that included in search result
    $publisher_terms_in_search_result = [];

    if( $changedSelectedTermIds == 'true' ){
        $args = [
            'post_type' => 'product',
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $mainProductCatId
                ],
            ],
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
        ];

        // if there is any of filter term id, change tax query
        if( !empty($filterTermIds) ){
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => explode(',', $filterTermIds)
                ],
            ];
        }

        $the_query = new WP_Query( $args );

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
            asort($publisher_terms_in_search_result);
        }
    }

    // default tax query is for the current category page cat id
    $args = [
        'post_type' => 'product',
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $mainProductCatId
            ],
        ],
        'post_status' => 'publish',
        'posts_per_page' => $productPerPage,
        'offset' => ( $page - 1 ) * $productPerPage,
    ];

    // if there is any of filter term id, change tax query
    if( !empty($filterTermIds) ){
        $args['tax_query'] = [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => explode(',', $filterTermIds)
            ],
        ];
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

    if( $productOrder === 'alphabetical' ){
        $args['orderby'] = 'title';
        $args['order'] = 'asc';
    } else if( $productOrder === 'published-date' ){
        $args['meta_key'] = 'book_first_published_date';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'desc';
    }
    
    global $post;
    
    $the_query = new WP_Query( $args );
    
    // get total search result count
    $products_search_count = $the_query->found_posts;
    $products_search_list = [];

    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            global $product;

            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            $authorIDs = get_field('book_contributors_syggrafeas', $post->ID);
            $author_list = [];

            foreach( $authorIDs as $authorID ){
                $author_list[] = [
                    'url' => get_permalink($authorID),
                    'title' => get_the_title($authorID)
                ];
            }

            $products_search_list[] = [
                'id' => $post->ID,
                'url' => get_permalink($post->ID),
                'placeholder' => placeholderImage($image[1], $image[2]),
                'image_url' => aq_resize($image[0], $image[1], $image[2], true),
                'title' => $post->post_title,
                'authors' => $author_list,
                'price' => $product->get_price_html(),
                'sku' => $product->get_sku(),
                'covertype' => get_field('book_cover_type', $product->ID),
            ];
        }
    }
    
    $pagination->records($products_search_count);
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        global $twig;

        $result = json_encode([
            'count' => $products_search_count,
            'result' => $twig->render('loop/loop-product-card.twig', ['products' => $products_search_list]),
            'navigation' => $pagination->render(true),
            'pageCounts' => $pagination->get_pages(),
            // 'productOrder' => $productOrder,
            // 'arg' => $args
            'author_list_in_search_result' => $author_list_in_search_result,
            'publisher_terms_in_search_result' => $publisher_terms_in_search_result,
            // 'changedSelectedTermIds' => $changedSelectedTermIds,
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}