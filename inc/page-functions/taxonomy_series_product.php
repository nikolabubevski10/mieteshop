<?php
add_action('wp_ajax_filter_taxonomy_series_product', 'filterTaxonomySeriesProductFunc');
add_action('wp_ajax_nopriv_filter_taxonomy_series_product', 'filterTaxonomySeriesProductFunc');

function filterTaxonomySeriesProductFunc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_taxonomy_series_product_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $seriesTermId = intval($_REQUEST['seriesTermId']);
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
        'list_item' => 'js-ts-product-navigation-item pcat-results-navigation-item',
        'prev' => 'js-ts-product-navigation-item pcat-results-navigation-prev',
        'next' => 'js-ts-product-navigation-item pcat-results-navigation-next',
        'anchor' => '',
    ]);
    
    global $post;

    // get all products
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $productPerPage,
        'offset' => ( $page - 1 ) * $productPerPage,
        'tax_query' => [
            [
                'taxonomy' => 'series',
                'field' => 'term_id',
                'terms' => $seriesTermId
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
    
    $the_query = new WP_Query( $args );

    $products_search_list = [];
    $products_search_count = $the_query->found_posts;

    if ( $the_query->have_posts() ) {

        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $product = wc_get_product( $post->ID );

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
                'title' => get_the_title($post->ID),
                'authors' => $author_list,
                'price' => $product->get_price_html(),
                'covertype' => get_field('book_cover_type', $product->ID),
            ];
        }
    }
    
    $pagination->records($products_search_count);
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        global $twig;

        $result = json_encode([
            'result' => $twig->render('loop/loop-product-card.twig', ['products' => $products_search_list]),
            'navigation' => $pagination->render(true),
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}