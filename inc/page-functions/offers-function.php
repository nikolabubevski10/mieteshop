<?php
add_action('wp_ajax_filter_offers_product', 'filterOffersProduct');
add_action('wp_ajax_nopriv_filter_offers_product', 'filterOffersProduct');

function filterOffersProduct()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_offers_product_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $productOrder = $_REQUEST['productOrder'];
    $page = intval($_REQUEST['page']);
    $productPerPage = intval($_REQUEST['productPerPage']);

    require_once dirname(dirname(__FILE__)) . '/zebra-pagination.php';

    $pagination = new Zebra_Pagination();
    $pagination->records_per_page($productPerPage);
    $pagination->selectable_pages(5);
    $pagination->set_page($page);
    $pagination->padding(false);
    $pagination->css_classes([
        'list' => 'pcat-results-navigation-row',
        'list_item' => 'js-offers-results-navigation-item pcat-results-navigation-item',
        'prev' => 'js-offers-results-navigation-item pcat-results-navigation-prev',
        'next' => 'js-offers-results-navigation-item pcat-results-navigation-next',
        'anchor' => '',
    ]);

    // default tax query is for the current category page cat id
    $args = [
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $productPerPage,
        'offset' => ( $page - 1 ) * $productPerPage,
        'tax_query' => [
            [
                'taxonomy' => 'epiloges',
                'field'    => 'slug',
                'terms'    => 'prosfores',
            ],
        ],
    ];

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
            'arg' => $args
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}