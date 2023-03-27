<?php
add_action('wp_ajax_filter_single_contributor_product', 'filterSingleContributorProductFunc');
add_action('wp_ajax_nopriv_filter_single_contributor_product', 'filterSingleContributorProductFunc');

function filterSingleContributorProductFunc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_single_contributor_product_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $filterContributorId = intval($_REQUEST['filterContributorId']);
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
        'list_item' => 'js-sc-product-navigation-item pcat-results-navigation-item',
        'prev' => 'js-sc-product-navigation-item pcat-results-navigation-prev',
        'next' => 'js-sc-product-navigation-item pcat-results-navigation-next',
        'anchor' => '',
    ]);

    $products_search_list = [];
    
    global $post;

    // get all products that has this single contributor
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $productPerPage,
        'offset' => ($page - 1) * $productPerPage,
        'meta_query' => [
			[
				'key'     => 'book_contributors_syggrafeas',
				'value'   => '"' . $filterContributorId . '"',
				'compare' => 'LIKE'
            ],
        ]
    ];
    
    $the_query = new WP_Query( $args );
    
    $count_product_list_include_single_contributor = $the_query->found_posts;

    if ( $the_query->have_posts() ) {
        
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $product = wc_get_product( $post->ID );

            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'full' );
            $authorIDs = get_field('book_contributors_syggrafeas', $product->get_id());
            $author_list = [];

            foreach( $authorIDs as $authorID ){
                $author_list[] = [
                    'url' => get_permalink($authorID),
                    'title' => get_the_title($authorID)
                ];
            }

            $products_search_list[] = [
                'id' => $post->ID,
                'url' => get_permalink($product->get_id()),
                'placeholder' => placeholderImage($image[1], $image[2]),
                'image_url' => aq_resize($image[0], $image[1], $image[2], true),
                'title' => get_the_title($product->get_id()),
                'authors' => $author_list,
                'price' => $product->get_price_html()
            ];
        }
    }
    
    $pagination->records($count_product_list_include_single_contributor);
    
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


/* added by Daphne to hook into save_post and update the contributor taxonomy */
/*
function update_contributor_taxonomy( $post_id, $post ){
    global $post; 

    // bail out if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }    

    //The "save_post" action is only called when we actually changed something in the post page form. 
    //If we just press the update button, without changing anything, the "save_post" action is not called.
    if ( $post->post_type == 'product' ) {
        $authorIDs = get_field( 'book_contributors_syggrafeas', $post->ID );
        if ( $authorIDs ) {
            //for each author update the specific contributor taxonomy to Συγγραφέας
            foreach($authorIDs as $authorID) {
                wp_set_object_terms( $authorID->ID, array(31), 'contributor_type', true ); //31 is the term id for Συγγραφέας
            }
        }
    }
}
add_action( 'save_post', 'update_contributor_taxonomy', 30, 2 );
*/

