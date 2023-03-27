<?php
add_action('wp_ajax_filter_search_art_object', 'filterSearchArtObjectFunc');
add_action('wp_ajax_nopriv_filter_search_art_object', 'filterSearchArtObjectFunc');

function filterSearchArtObjectFunc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_search_art_object_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $filterTermId = intval($_REQUEST['filterTermId']);
    $searchKey = $_REQUEST['searchKey'];
    $filterAuthorId = intval($_REQUEST['filterAuthorId']);
    $filterPublisherId = intval($_REQUEST['filterPublisherId']);
    $page = intval($_REQUEST['page']);
    $productPerPage = intval($_REQUEST['productPerPage']);
    $productOrder = $_REQUEST['productOrder'];

    require_once dirname(dirname(__FILE__)) . '/zebra-pagination.php';

    $pagination = new Zebra_Pagination();
    $pagination->records_per_page($productPerPage);
    $pagination->selectable_pages(5);
    $pagination->set_page($page);
    $pagination->padding(false);
    $pagination->css_classes([
        'list' => 'pcat-results-navigation-row',
        'list_item' => 'js-search-art-object__results-navigation-item pcat-results-navigation-item',
        'prev' => 'js-search-art-object__results-navigation-item pcat-results-navigation-prev',
        'next' => 'js-search-art-object__results-navigation-item pcat-results-navigation-next',
        'anchor' => '',
    ]);

    $args = [
        'post_type' => 'product',
        // 'search_prod_title' => $searchKey,
        'search_prod_title_sub_title' => $searchKey,
        'posts_per_page' => $productPerPage,
        'offset' => ( $page - 1 ) * $productPerPage,
        'tax_query' => [
            [
                'taxonomy' => 'title_type',
                'field' => 'slug',
                'terms' => 'book',
                'operator' => 'NOT IN',
            ]
        ],
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
    ];

    // if there is any of filter term id, change tax query
    if( !empty($filterTermId) ){
        $args['tax_query']['relation'] = 'AND';
        
        $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $filterTermId
        ];
    }

    if( !empty($filterAuthorId) ){
        $args['meta_query'][] = [
            'key'     => 'book_contributors_syggrafeas',
            'value'   => '"' . $filterAuthorId . '"',
            'compare' => 'LIKE'
        ];
    }

    if( !empty($filterPublisherId) ){
        $args['tax_query']['relation'] = 'AND';
        
        $args['tax_query'][] = [
            'taxonomy' => 'ekdotes',
            'field' => 'term_id',
            'terms' => $filterPublisherId
        ];
    }

    if( $productOrder === 'alphabetical' ){
        $args['orderby'] = 'title';
        $args['order'] = 'asc';
    } else if( $productOrder === 'published-date' ){
        $args['orderby'] = [
            'book_first_published_date_clause' => 'DESC',
        ];
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
            'arg' => $args
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}