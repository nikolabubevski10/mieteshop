<?php
add_action('wp_ajax_filter_search_archive_contributor', 'filterSearchArchiveContributorFunc');
add_action('wp_ajax_nopriv_filter_search_archive_contributor', 'filterSearchArchiveContributorFunc');

function filterSearchArchiveContributorFunc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_search_archive_contributor_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $firstLetters = $_REQUEST['firstLetters'];
    $html = '';

    $args = [
        'post_type' => 'contributor',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_key' => 'contributor_first_name',
        'meta_query' => [
            [
                'key'     => 'book_contributors_syggrafeas',
                'value'   => array(''),
                'compare' => 'NOT IN',
            ],
            'contributor_last_name_clause' => [
                'key' => 'contributor_last_name',
                'value'   => '^' . $firstLetters[0],
                'compare' => 'REGEXP',
            ],
        ],
        'orderby' => [
            'contributor_last_name_clause' => 'ASC',
            'meta_value' => 'ASC',
        ]
    ];

    global $post;

    $loop = new WP_Query( $args );

    $contrCount=0;

    foreach( $loop->posts as $contributor_id ) {    
        $ContributorBooks = get_field('book_contributors_syggrafeas', $contributor_id);

        // check that the contributor is connected with published books
        $atLeastOnePublished = false;
        foreach($ContributorBooks as $ContributorBook) {
            if($ContributorBook->post_status == 'publish') {
                $atLeastOnePublished = true;
                break; //we found at a published book no need to search the rest
            }
        }   
        
        if($atLeastOnePublished === true) { //display only contributors who have at least one published book
            $html .= '<div class="archive-contributor-search-result-col"><a href="' . get_permalink($contributor_id) .'">' . get_field('contributor_last_name', $contributor_id) . ' ' . get_field('contributor_first_name', $contributor_id) .'</a></div>';
            $contrCount++;
        }

        
    }

    wp_reset_query();
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $result = json_encode([
            'result' => $html,
            'count' => $contrCount
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}