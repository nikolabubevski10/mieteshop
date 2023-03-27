<?php
add_action('init', function (){
    $labels = [
        'name'                  => _x('Συντελεστές', 'Συντελεστής General Name', 'flynt'),
        'singular_name'         => _x('Συντελεστής', 'Συντελεστής Singular Name', 'flynt'),
        'menu_name'             => __('Συντελεστές', 'flynt'),
        'name_admin_bar'        => __('Συντελεστής', 'flynt'),
        'archives'              => __('Item Archives', 'flynt'),
        'attributes'            => __('Item Attributes', 'flynt'),
        'parent_item_colon'     => __('Parent Item:', 'flynt'),
        'all_items'             => __('All Συντελεστές', 'flynt'),
        'add_new_item'          => __('Add New Συντελεστής', 'flynt'),
        'add_new'               => __('Add New', 'flynt'),
        'new_item'              => __('New Συντελεστής', 'flynt'),
        'edit_item'             => __('Edit Συντελεστής', 'flynt'),
        'update_item'           => __('Update Συντελεστής', 'flynt'),
        'view_item'             => __('View Συντελεστής', 'flynt'),
        'view_items'            => __('View Συντελεστές', 'flynt'),
        'search_items'          => __('Search Συντελεστής', 'flynt'),
        'not_found'             => __('Not found', 'flynt'),
        'not_found_in_trash'    => __('Not found in Trash', 'flynt'),
        'featured_image'        => __('Featured Image', 'flynt'),
        'set_featured_image'    => __('Set featured image', 'flynt'),
        'remove_featured_image' => __('Remove featured image', 'flynt'),
        'use_featured_image'    => __('Use as featured image', 'flynt'),
        'insert_into_item'      => __('Insert into συντελεστής', 'flynt'),
        'uploaded_to_this_item' => __('Uploaded to this συντελεστής', 'flynt'),
        'items_list'            => __('Συντελεστές list', 'flynt'),
        'items_list_navigation' => __('Συντελεστές list navigation', 'flynt'),
        'filter_items_list'     => __('Filter Συντελεστές list', 'flynt'),
    ];

    $args = [
        'label'                 => __('Συντελεστής', 'flynt'),
        'description'           => __('Συντελεστής Description', 'flynt'),
        'labels'                => $labels,
        'supports'              => ['title', 'thumbnail', 'editor'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'menu_icon'             => 'dashicons-money',
    ];

    register_post_type('contributor', $args);
    
    // add custom taxonomy to contributor
    $labels = [
        'name'                       => _x('Τύποι Συντελεστών', 'Τύπος Συντελεστή General Name', 'flynt'),
        'singular_name'              => _x('Τύπος Συντελεστή', 'Τύπος Συντελεστή Singular Name', 'flynt'),
        'menu_name'                  => __('Τύπος Συντελεστή', 'flynt'),
        'all_items'                  => __('All Τύποι Συντελεστών', 'flynt'),
        'parent_item'                => __('Parent Τύπος Συντελεστή', 'flynt'),
        'parent_item_colon'          => __('Parent Τύπος Συντελεστή:', 'flynt'),
        'new_item_name'              => __('New Τύπος Συντελεστή Name', 'flynt'),
        'add_new_item'               => __('Add New Τύπος Συντελεστή', 'flynt'),
        'edit_item'                  => __('Edit Τύπος Συντελεστή', 'flynt'),
        'update_item'                => __('Update Τύπος Συντελεστή', 'flynt'),
        'view_item'                  => __('View Τύπος Συντελεστή', 'flynt'),
        'separate_items_with_commas' => __('Separate Τύποι Συντελεστών with commas', 'flynt'),
        'add_or_remove_items'        => __('Add or remove Τύποι Συντελεστών', 'flynt'),
        'choose_from_most_used'      => __('Choose from the most used', 'flynt'),
        'popular_items'              => __('Popular Τύποι Συντελεστών', 'flynt'),
        'search_items'               => __('Search Τύποι Συντελεστών', 'flynt'),
        'not_found'                  => __('Not Found', 'flynt'),
        'no_terms'                   => __('No Τύποι Συντελεστών', 'flynt'),
        'items_list'                 => __('Τύποι Συντελεστών list', 'flynt'),
        'items_list_navigation'      => __('Τύποι Συντελεστών list navigation', 'flynt'),
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => false,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    ];

    register_taxonomy('contributor_type', ['contributor'], $args);
});

add_filter('manage_contributor_posts_columns', function($columns){
    return [
        'cb' => $columns['cb'],
        'image' => 'Image',
        'title' => $columns['title'],
        'taxonomy-contributor_type' => $columns['taxonomy-contributor_type'],
        'contributor_biblionet_id' => 'Contributor Biblionet ID',
        'born_died' => 'Born Died',
        'date' => $columns['date'],
    ];
});

add_action('manage_contributor_posts_custom_column', function($column, $post_id){
    if ($column == 'image') {
        echo get_the_post_thumbnail($post_id, 'thumbnail');
    } else if ($column == 'contributor_biblionet_id') {
        echo get_field('contributor_biblionet_id', $post_id);
    } else if ($column == 'born_died') {
        echo get_field('contributor_born_died', $post_id);
    }
}, 10, 2);
