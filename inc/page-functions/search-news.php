<?php
add_action('wp_ajax_search_news_result', 'searchNewsResultFunc');
add_action('wp_ajax_nopriv_search_news_result', 'searchNewsResultFunc');

function searchNewsResultFunc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_search_news_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $searchKey = $_REQUEST['searchKey'];
    $page = intval($_REQUEST['page']);
    $postsPerPage = intval($_REQUEST['postsPerPage']);
    $greek_month_list = ['ΙΑΝ', 'ΦΕΒ', 'ΜΆΡ', 'ΑΠΡ', 'ΜΆΙ', 'ΙΟΎΝ', 'ΙΟΎΛ', 'ΑΎΓ', 'ΣΕΠ', 'ΟΚΤ', 'ΝΟΈ', 'ΔΕΚ'];

    require_once dirname(dirname(__FILE__)) . '/zebra-pagination.php';

    $pagination = new Zebra_Pagination();
    $pagination->records_per_page($postsPerPage);
    $pagination->selectable_pages(5);
    $pagination->set_page($page);
    $pagination->padding(false);
    $pagination->css_classes([
        'list' => 'pcat-results-navigation-row',
        'list_item' => 'js-search-news__results-navigation-item pcat-results-navigation-item',
        'prev' => 'js-search-news__results-navigation-item pcat-results-navigation-prev',
        'next' => 'js-search-news__results-navigation-item pcat-results-navigation-next',
        'anchor' => '',
    ]);

    $blog_search_list = [];
    
    global $post;

    $args = [
        'post_type' => 'post',
        'search_prod_title' => $searchKey,
        'post_status' => 'publish',
        'posts_per_page' => $postsPerPage,
        'offset' => ($page - 1) * $postsPerPage,
    ];
    
    $the_query = new WP_Query( $args );
    $total_post_count = $the_query->found_posts;
    
    $blog_list = [];

    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
            $terms = wp_get_post_terms( $post->ID, 'category' );
            $term_list = [];

            foreach( $terms as $term ){
                $term_list[] = [
                    'id' => $term->term_id,
                    'name' => $term->name,
                    'url' => get_permalink($term->term_id)
                ];
            }

            $date = get_the_date('j', $post->ID) . ' ' . $greek_month_list[get_the_date('n', $post->ID) - 1] . ' ' . get_the_date('Y', $post->ID);

            $blog_list[] = [
                'id' => $post->ID,
                'title' => $post->post_title,
                'url' => get_permalink($post->ID),
                'placeholder' => placeholderImage($image[1], $image[2]),
                'image_url' => aq_resize($image[0], $image[1], $image[2], true),
                'term_list' => $term_list,
                'date' => $date,
                'post_lead' => get_field('post_lead', $post->ID),
                'event_from_date' => get_field('event_from_date', $post->ID),
                'event_to_date' => get_field('event_to_date', $post->ID),
            ];
        }
    }
    
    $pagination->records($total_post_count);
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        global $twig;

        $result = json_encode([
            'result' => $twig->render('blog-result.twig', ['blog_list' => $blog_list]),
            'navigation' => $pagination->render(true)
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}