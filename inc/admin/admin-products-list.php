<?php

/* Add product publisher taxonomy filter */
function product_publisher_filter() {
	
	global $typenow;
	
	$post_type	= 'product';	// My Custom Post Type
	$taxonomy	= 'ekdotes';		// My Custom Taxonomy
	
	if( $post_type == $typenow ) {
		
		$selected		= isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
		$info_taxonomy	= get_taxonomy( $taxonomy );
		
		wp_dropdown_categories( array(
			'show_option_all'	=> esc_html__( "Φιλτράρισμα με {$info_taxonomy->label}" ),
			'taxonomy'			=> $taxonomy,
			'name'				=> $taxonomy,
			'orderby'			=> 'name',
			'selected'			=> $selected,
			'value_field'		=> 'slug',
			'show_count'		=> true,
			'hide_empty'		=> true,
		) );
		
	}
	
}
add_action( 'restrict_manage_posts', 'product_publisher_filter' );

	
/* Remove Yoast SEO Filters */
function custom_remove_yoast_seo_admin_filters() {
    global $wpseo_meta_columns;
    if ($wpseo_meta_columns) {
        remove_action('restrict_manage_posts', array($wpseo_meta_columns, 'posts_filter_dropdown'));
        remove_action('restrict_manage_posts', array($wpseo_meta_columns, 'posts_filter_dropdown_readability'));
    }
}
add_action('admin_init', 'custom_remove_yoast_seo_admin_filters', 20);

/*
if (is_admin()){

    //this hook will create a new filter on the admin area for the specified post type
    function adminProductFilterbyPublisher(){
        $screen = get_current_screen();

        if( $screen->id == 'edit-product' ){
            $publisherList = get_posts([
                'post_type'  => 'publisher',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            ]);
            ?>
                <select name="admin_filter_publisher">
                    <option value="0">All Publishers</option>
                    <?php
                        $current_v = isset($_GET['admin_filter_publisher'])? intval($_GET['admin_filter_publisher']) : 0;
                        foreach($publisherList as $publisher){
                    ?>
                            <option value="<?php echo $publisher->ID; ?>" <?php echo $current_v === $publisher->ID ? 'selected="selected"' : ''; ?>><?php echo $publisher->post_title; ?></option>
                    <?php
                        }
                    ?>
                </select>
            <?php
        }
    }
    add_action('restrict_manage_posts', 'adminProductFilterbyPublisher', 100);

    function adminProductFilterbyPublisherResult($query){
        $screen = get_current_screen();

        if( $screen->id == 'edit-product' && $query->query['post_type'] === 'product' && isset($_GET['admin_filter_publisher']) && !empty($_GET['admin_filter_publisher']) ){
            $query->set('meta_query', [
                [
                    'key'     => 'book_publishers',
                    'value'   => '"' . $_GET['admin_filter_publisher'] . '"',
                    'compare' => 'LIKE',
                ]
            ]);
        }
    }
    add_filter('pre_get_posts', 'adminProductFilterbyPublisherResult');
}
*/