<?php
// add wp_query arg to search only in title
function title_filter( $where, $wp_query ){
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
        // $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $search_term ) ) . '%\'';
        $where .= " AND {$wpdb->posts}.post_title LIKE '%" . esc_sql( like_escape( $search_term ) ) . "%'";
    }
    return $where;
}

add_filter( 'posts_where', 'title_filter', 10, 2 );

// add wp_query arg to search only in title and book_subtitle custom meta field
function title_sub_title_filter( $where, $wp_query ){
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title_sub_title' ) ) {
        // remove  AND ( ( wp_postmeta.meta_key = '' AND wp_postmeta.meta_value = '' ) )
        // this Need to add this so query_posts joins the postmeta table in the query.
        // $where = str_replace("( {$wpdb->postmeta}.meta_key = '' AND {$wpdb->postmeta}.meta_value = '' )", "1", $where);  
        $where .= " AND ( {$wpdb->posts}.post_title LIKE '%" . esc_sql( like_escape( $search_term ) ) . "%' OR ({$wpdb->postmeta}.meta_key LIKE 'book_subtitle' AND {$wpdb->postmeta}.meta_value LIKE '%" . esc_sql( like_escape( $search_term ) ) . "%') )";
    }

    return $where;
}

add_filter( 'posts_where', 'title_sub_title_filter', 10, 2 );

add_action('wp_ajax_header_top_search', 'headerTopSearchFuc');
add_action('wp_ajax_nopriv_header_top_search', 'headerTopSearchFuc');

function headerTopSearchFuc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'header_top_search_nonce')) {
        exit('No naughty business please');
    }
    
    $searchKey = $_REQUEST['searchKey'];

    // product cat search with search key
    $child_cat_search_list = get_terms([
        'taxonomy' => 'product_cat', 
        'hide_empty' => false, 
        'name__like' => $searchKey
    ]);

    $child_cat_list = [];
    $child_cat_list_count = count($child_cat_search_list);

    foreach( $child_cat_search_list as $key => $cat ){
        if( $key > 3 ){
            break;
        }

        $product_cat_parent_list = array_reverse(get_ancestors($cat->term_id, 'product_cat'));

        $term_list = [];
        foreach( $product_cat_parent_list as $parent ){
            $parent_object = get_term($parent);

            $term_list[] = [
                'title' => $parent_object->name,
                'url' => get_term_link($parent_object->term_id)
            ];
        }

        $term_list[] = [
            'title' => $cat->name,
            'url' => get_term_link($cat->term_id)
        ];

        $child_cat_list[] = $term_list;
    }

    global $post;

    // publisher search with search key
    $publisher_term_list = get_terms([
        'taxonomy' => 'ekdotes', 
        'hide_empty' => true, 
        'orderby' => 'title',
        'order' => 'ASC',
        'name__like' => $searchKey,
        'number' => 4,
    ]);

    $publisher_list = [];
    $publisher_list_count = count($publisher_term_list);
 
    foreach($publisher_term_list as $term){
        $publisher_list[] = [
            'title' => $term->name,
            'url' => get_term_link($term->term_id),
        ];
    }

    // contributor search with search key
    $the_query = new WP_Query([
        'post_type' => 'contributor',
        'posts_per_page' => 4,
        // 's' => $searchKey
        'search_prod_title' => $searchKey,
        'post_status' => 'publish'
    ]);

    $contributor_list = [];
    $contributor_list_count = $the_query->found_posts;
 
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $contributor_list[] = [
                'title' => $post->post_title,
                'url' => get_permalink($post->ID),
            ];
        }
    }

    wp_reset_postdata();
    
    // product (title_type is only book type) search with search key
    $the_query = new WP_Query([
        'post_type' => 'product',
        'posts_per_page' => 4,
        // 's' => $searchKey,
        // 'search_prod_title' => $searchKey,
        'search_prod_title_sub_title' => $searchKey,
        'tax_query' => [
            [
                'taxonomy' => 'title_type',
                'field' => 'slug',
                'terms' => 'book',
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
    ]);

    $product_book_list = [];
    $product_book_list_count = $the_query->found_posts;
 
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

            $authorIDs = get_field('book_contributors_syggrafeas', $post->ID);

            $author_list = [];

            foreach( $authorIDs as $authorID ){
                $author_list[] = [
                    'url' => get_permalink($authorID),
                    'title' => get_the_title($authorID)
                ];
            }

            $product_book_list[] = [
                'title' => $post->post_title,
                'url' => get_permalink($post->ID),
                'placeholder' => placeholderImage($image[1], $image[2]),
                'imageurl' => aq_resize($image[0], $image[1], $image[2], true),
                'authors' => $author_list,
                'book_cover_type' => get_field('book_cover_type', $post->ID),
            ];
        }
    }

    wp_reset_postdata();

    // product (title_type is not only book type) search with search key
    $the_query = new WP_Query([
        'post_type' => 'product',
        'posts_per_page' => 4,
        // 's' => $searchKey,
        // 'search_prod_title' => $searchKey,
        'search_prod_title_sub_title' => $searchKey,
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
    ]);

    $product_art_object_list = [];
    $product_art_object_list_count = $the_query->found_posts;
 
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

            $authorIDs = get_field('book_contributors_syggrafeas', $post->ID);

            $author_list = [];

            foreach( $authorIDs as $authorID ){
                $author_list[] = [
                    'url' => get_permalink($authorID),
                    'title' => get_the_title($authorID)
                ];
            }

            $product_art_object_list[] = [
                'title' => $post->post_title,
                'url' => get_permalink($post->ID),
                'placeholder' => placeholderImage($image[1], $image[2]),
                'imageurl' => aq_resize($image[0], $image[1], $image[2], true),
                'authors' => $author_list,
                'book_cover_type' => get_field('book_cover_type', $post->ID),
            ];
        }
    }

    wp_reset_postdata();
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        global $twig;

        $result = json_encode([
            'result' => $twig->render(
                'header-top-search-result.twig',
                [
                    'child_cat_list' => $child_cat_list,
                    'child_cat_list_count' => $child_cat_list_count,
                    'publisher_list' => $publisher_list,
                    'publisher_list_count' => $publisher_list_count,
                    'contributor_list' => $contributor_list,
                    'contributor_list_count' => $contributor_list_count,
                    'product_book_list' => $product_book_list,
                    'product_book_list_count' => $product_book_list_count,
                    'product_art_object_list' => $product_art_object_list,
                    'product_art_object_list_count' => $product_art_object_list_count,
                    'search_key' => $searchKey,
                    'site_url' => get_site_url()
                ]
            ),
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}