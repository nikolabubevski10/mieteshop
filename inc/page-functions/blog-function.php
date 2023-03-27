<?php
add_action('wp_ajax_filter_blog_result', 'filterBlogResultFunc');
add_action('wp_ajax_nopriv_filter_blog_result', 'filterBlogResultFunc');

function filterBlogResultFunc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'filter_blog_result_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $catId = intval($_REQUEST['catId']);
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
        'list_item' => 'js-blog-result-navigation-item pcat-results-navigation-item',
        'prev' => 'js-blog-result-navigation-item pcat-results-navigation-prev',
        'next' => 'js-blog-result-navigation-item pcat-results-navigation-next',
        'anchor' => '',
    ]);

    $blog_search_list = [];
    
    global $post;

    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $postsPerPage,
        'offset' => ($page - 1) * $postsPerPage,
    ];

    if( $catId > 0 ){
        $args['cat'] = $catId;
    }
    
    $the_query = new WP_Query( $args );
    $total_post_count = $the_query->found_posts;
    
    $first_blog = [];
    $blog_list = [];

    if ( $the_query->have_posts() ) {
        $index = 0;
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

            if( $index === 0 ){
                $first_blog = [
                    'id' => $post->ID,
                    'title' => $post->post_title,
                    'url' => get_permalink($post->ID),
                    'placeholder' => placeholderImage($image[1], $image[2]),
                    'image_url' => aq_resize($image[0], $image[1], $image[2], true),
                    'term_list' => $term_list,
                    'date' => $date,
                    'post_lead' => get_field('post_lead', $post->ID) 
                ];
            } else {
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

            $index++;
        }
    }
    
    $pagination->records($total_post_count);
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        global $twig;

        $result = json_encode([
            'hero' => $twig->render('blog-hero.twig', ['first_blog' => $first_blog]),
            'result' => $twig->render('blog-result.twig', ['blog_list' => $blog_list]),
            'navigation' => $pagination->render(true),
            'pageCounts' => $pagination->get_pages(),
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}

add_action('wp_ajax_blog_cat_result', 'blogCatResultFunc');
add_action('wp_ajax_nopriv_blog_cat_result', 'blogCatResultFunc');

function blogCatResultFunc()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], 'blog_cat_result_nonce')) {
        exit('No naughty business please');
    }

    $result = [];
    
    $catId = intval($_REQUEST['catId']);
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
        'list_item' => 'js-blog-cat-result-navigation-item pcat-results-navigation-item',
        'prev' => 'js-blog-cat-result-navigation-item pcat-results-navigation-prev',
        'next' => 'js-blog-cat-result-navigation-item pcat-results-navigation-next',
        'anchor' => '',
    ]);

    $blog_search_list = [];
    
    global $post;

    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $postsPerPage,
        'offset' => ($page - 1) * $postsPerPage,
    ];

    if( $catId > 0 ){
        $args['cat'] = $catId;
    }
    
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
            'navigation' => $pagination->render(true),
            'pageCounts' => $pagination->get_pages(),
        ]);

        echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

    die();
}