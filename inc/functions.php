<?php
// Disable Gutenberg
add_filter( 'use_block_editor_for_post_type', '__return_false' );

add_filter( 'jetpack_sharing_counts', '__return_false', 99 );
add_filter( 'jetpack_implode_frontend_css', '__return_false', 99 );

add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
function prefix_disable_gutenberg($current_status, $post_type){
  // Use your post type key instead of 'product'
  if ($post_type === 'post') return $current_status;
  
  return false;
}

/**
 * Removes Gutenberg default styles on front-end
 */
add_action('wp_print_styles', function () {
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
});

add_action( 'wp_footer', function () {
  wp_dequeue_script( 'wp-embed' );
});

// remove post wisying editor
add_action( 'init', function() {
  remove_post_type_support( 'post', 'editor' );
}, 99);

// add custom theme css & js
add_filter('script_loader_tag', function ($tag, $handle){
  foreach (['async', 'defer'] as $attr) {
    if (!wp_scripts()->get_data($handle, $attr)) {
      continue;
    }
    // Prevent adding attribute when already added in #12009.
    if (!preg_match(":\s$attr(=|>|\s):", $tag)) {
        $tag = preg_replace(':(?=></script>):', " $attr", $tag, 1);
    }
    // Only allow async or defer, not both.
    break;
  }
  return $tag;
}, 10, 2);

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script(
    'mieteshop-assets',
    get_template_directory_uri() . '/dist/assets/main.js',
    ['jquery'],
    filemtime(get_template_directory() . '/dist/assets/main.js'),
    true
  );
  wp_script_add_data('mieteshop-assets', 'defer', true);

  $data = [
    'ajaxurl' => admin_url('admin-ajax.php'),
    'templateDirectoryUri' => get_template_directory_uri(),
    'siteurl' => get_site_url()
  ];
  wp_localize_script('mieteshop-assets', 'MieteshopData', $data);

  wp_enqueue_style(
    'mieteshop-assets',
    get_template_directory_uri() . '/dist/assets/main.css',
    [],
    filemtime(get_template_directory() . '/dist/assets/main.css')
  );
});

function populate_children($menu_array, $menu_item){
  $children = [];
  $cpi = get_queried_object_id();

  if (!empty($menu_array)){
    foreach ($menu_array as $k=>$m) {
      if ($m->menu_item_parent == $menu_item->ID) {
        $children[$m->ID] = [
          'ID' => $m->ID,
          'title' => $m->title,
          'url' => $m->url,
          'class' => $cpi == $m->object_id ? 'active' : '',
          'children' => populate_children($menu_array, $m)
        ];

        $children[$m->ID]['has_child'] = !empty($children[$m->ID]['children']);

        unset($menu_array[$k]);
      }
    }
  };

  return $children;
}

function wp_get_menu_array($current_menu) {
  $menu_array = wp_get_nav_menu_items($current_menu);

  $cpi = get_queried_object_id();

  foreach ($menu_array as $m) {
    if (empty($m->menu_item_parent)) {
      $menu[$m->ID] = [
        'ID' => $m->ID,
        'title' => $m->title,
        'url' => $m->url,
        'class' => $cpi == $m->object_id ? 'active' : '',
        'children' => populate_children($menu_array, $m)
      ];

      $menu[$m->ID]['has_child'] = !empty($menu[$m->ID]['children']);
    }
  }

  return $menu;
}

// add options page
if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page(array(
    'page_title' 	=> 'Global Options',
    'menu_title'	=> 'Global Options',
    'menu_slug' 	=> 'global-options'
  ));	
}

include_once 'woo-functions.php';

include_once 'aq-resizer.php';
include_once 'helper.php';

include_once 'custom-post-types/contributor.php';

include_once 'page-functions/category-product-function.php';
include_once 'page-functions/header-top-search-function.php';
include_once 'page-functions/search-book-function.php';
include_once 'page-functions/search-art-object-function.php';
include_once 'page-functions/archive-publisher-function.php';
include_once 'page-functions/archive-contributor-function.php';
include_once 'page-functions/single-publisher-function.php';
include_once 'page-functions/single-contributor-function.php';
include_once 'page-functions/taxonomy_series_product.php';
include_once 'page-functions/blog-function.php';
include_once 'page-functions/offers-function.php';
include_once 'page-functions/best-sellers-function.php';
include_once 'page-functions/search-news.php';

include_once 'admin/admin-products-list.php';

include_once 'woo_account_extra_fields.php';



