<?php
// add wp_query arg to search only in title with first letter
function title_filter_with_first_letter( $where, $wp_query ){
    global $wpdb;

    if ( $search_term = $wp_query->get( 'search_title_with_first_letter' ) ) {
        if( !empty($search_term) ){
            $where .= ' AND ';
            
            if( is_array($search_term) ){

                $s = '';

                foreach($search_term as $item){
                    if( !empty($s) ){
                        $s .= ' OR ';
                    }

                    $s .= $wpdb->posts . '.post_title LIKE \'' . esc_sql( like_escape( $item ) ) . '%\'';
                }

                $where .= '(' . $s . ')';
            } else {
                $where .= $wpdb->posts . '.post_title LIKE \'' . esc_sql( like_escape( $search_term ) ) . '%\'';
            }
        }
    }
    
    return $where;
}

add_filter( 'posts_where', 'title_filter_with_first_letter', 10, 2 );


// add get_terms arg to search only in title with first letter
function terms_clauses_title_filter_with_first_letter( $clauses, $taxonomies, $args ){
    global $wpdb;

    if( empty( $args['search_title_with_first_letter'] ) ){
        return $clauses;
    }

    if( is_array($args['search_title_with_first_letter']) ){

        $s = '';

        foreach($args['search_title_with_first_letter'] as $item){
            if( !empty($s) ){
                $s .= ' OR ';
            }

            $s .= $wpdb->prepare( "t.name LIKE %s", $wpdb->esc_like( $item ) . '%' );
        }

        $clauses['where'] .= ' AND (' . $s . ')';
    } else {
        $clauses['where'] .= ' AND ' . $wpdb->prepare( "t.name LIKE %s", $wpdb->esc_like( $args['search_title_with_first_letter'] ) . '%' );
    }
    
    return $clauses;
}

add_filter( 'terms_clauses', 'terms_clauses_title_filter_with_first_letter', 10, 3 );

add_action('wp_ajax_filter_search_archive_publisher', 'filterSearchArchivePublisherFunc');
add_action('wp_ajax_nopriv_filter_search_archive_publisher', 'filterSearchArchivePublisherFunc');

function filterSearchArchivePublisherFunc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_search_archive_publisher_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $firstLetters = $_REQUEST['firstLetters'];
    $publisherTypeList = $_REQUEST['publisherTypeList'];
    $html = '';

    $args = [
        'taxonomy' => 'ekdotes', 
        'posts_per_page' => -1,
        'search_title_with_first_letter' => $firstLetters,
        'hide_empty' => true, 
        'orderby' => 'title',
        'order' => 'ASC'
    ];

    if( !empty($publisherTypeList) ){
        $args['meta_query'] = [
            [
                'key' => 'publisher_type_field',
                'value' => $publisherTypeList,
                'compare' => 'IN'
            ]
        ];
    }

    $publisher_term_list = get_terms( $args );
    
    foreach($publisher_term_list as $term){
        if($term->term_id != 563) {
            $html .= '<div class="archive-publisher-search-result-col"><a href="' . get_term_link($term->term_id) .'">' . $term->name .'</a></div>';
        }
    }
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $result = json_encode([
            'result' => $html,
            'args' => $args
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}