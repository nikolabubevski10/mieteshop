<?php
function mieteshop_add_woocommerce_support(){
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'mieteshop_add_woocommerce_support' );

// Disable the woocommerce default stylesheet
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * Disable WooCommerce block styles (front-end).
 */
add_action( 'wp_enqueue_scripts', function(){
    wp_dequeue_style( 'wc-block-style' );
});

// add custom taxonomies into product
add_action('init', function (){
    $labels = [
        'name'                       => _x('Τύπος', 'Τύπο General Name', 'flynt'),
        'singular_name'              => _x('Τύπο', 'Τύπο Singular Name', 'flynt'),
        'menu_name'                  => __('Τύπο', 'flynt'),
        'all_items'                  => __('All Τύπος', 'flynt'),
        'parent_item'                => __('Parent Τύπο', 'flynt'),
        'parent_item_colon'          => __('Parent Τύπο:', 'flynt'),
        'new_item_name'              => __('New Τύπο Name', 'flynt'),
        'add_new_item'               => __('Add New Τύπο', 'flynt'),
        'edit_item'                  => __('Edit Τύπο', 'flynt'),
        'update_item'                => __('Update Τύπο', 'flynt'),
        'view_item'                  => __('View Τύπο', 'flynt'),
        'separate_items_with_commas' => __('Separate Τύπος with commas', 'flynt'),
        'add_or_remove_items'        => __('Add or remove Τύπος', 'flynt'),
        'choose_from_most_used'      => __('Choose from the most used', 'flynt'),
        'popular_items'              => __('Popular Τύπος', 'flynt'),
        'search_items'               => __('Search Τύπος', 'flynt'),
        'not_found'                  => __('Not Found', 'flynt'),
        'no_terms'                   => __('No Τύπος', 'flynt'),
        'items_list'                 => __('Τύπος list', 'flynt'),
        'items_list_navigation'      => __('Τύπος list navigation', 'flynt'),
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => false,
        'show_ui'                    => true,
        'show_admin_column'          => false,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    ];

    register_taxonomy('title_type', ['product'], $args);

    $labels = [
        'name'                       => _x('Σειρές', 'Σειρά General Name', 'flynt'),
        'singular_name'              => _x('Σειρά', 'Σειρά Singular Name', 'flynt'),
        'menu_name'                  => __('Σειρά', 'flynt'),
        'all_items'                  => __('All Σειρές', 'flynt'),
        'parent_item'                => __('Parent Σειρά', 'flynt'),
        'parent_item_colon'          => __('Parent Σειρά:', 'flynt'),
        'new_item_name'              => __('New Σειρά Name', 'flynt'),
        'add_new_item'               => __('Add New Σειρά', 'flynt'),
        'edit_item'                  => __('Edit Σειρά', 'flynt'),
        'update_item'                => __('Update Σειρά', 'flynt'),
        'view_item'                  => __('View Σειρά', 'flynt'),
        'separate_items_with_commas' => __('Separate Σειρές with commas', 'flynt'),
        'add_or_remove_items'        => __('Add or remove Σειρές', 'flynt'),
        'choose_from_most_used'      => __('Choose from the most used', 'flynt'),
        'popular_items'              => __('Popular Σειρές', 'flynt'),
        'search_items'               => __('Search Σειρές', 'flynt'),
        'not_found'                  => __('Not Found', 'flynt'),
        'no_terms'                   => __('No Σειρές', 'flynt'),
        'items_list'                 => __('Σειρές list', 'flynt'),
        'items_list_navigation'      => __('Σειρές list navigation', 'flynt'),
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => false,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    ];

    register_taxonomy('series', ['product'], $args);

    $labels = [
        'name'                       => _x('Επιλογές', 'Επιλογή General Name', 'flynt'),
        'singular_name'              => _x('Επιλογή', 'Επιλογή Singular Name', 'flynt'),
        'menu_name'                  => __('Επιλογή', 'flynt'),
        'all_items'                  => __('All Επιλογές', 'flynt'),
        'parent_item'                => __('Parent Επιλογή', 'flynt'),
        'parent_item_colon'          => __('Parent Επιλογή:', 'flynt'),
        'new_item_name'              => __('New Επιλογή Name', 'flynt'),
        'add_new_item'               => __('Add New Επιλογή', 'flynt'),
        'edit_item'                  => __('Edit Επιλογή', 'flynt'),
        'update_item'                => __('Update Επιλογή', 'flynt'),
        'view_item'                  => __('View Επιλογή', 'flynt'),
        'separate_items_with_commas' => __('Separate Επιλογές with commas', 'flynt'),
        'add_or_remove_items'        => __('Add or remove Επιλογές', 'flynt'),
        'choose_from_most_used'      => __('Choose from the most used', 'flynt'),
        'popular_items'              => __('Popular Επιλογές', 'flynt'),
        'search_items'               => __('Search Επιλογές', 'flynt'),
        'not_found'                  => __('Not Found', 'flynt'),
        'no_terms'                   => __('No Επιλογές', 'flynt'),
        'items_list'                 => __('Επιλογές list', 'flynt'),
        'items_list_navigation'      => __('Επιλογές list navigation', 'flynt'),
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

    register_taxonomy('epiloges', ['product'], $args);

    $labels = [
        'name'                       => _x('Εκδότες', 'Εκδότης General Name', 'flynt'),
        'singular_name'              => _x('Εκδότης', 'Εκδότης Singular Name', 'flynt'),
        'menu_name'                  => __('Εκδότης', 'flynt'),
        'all_items'                  => __('All Εκδότης', 'flynt'),
        'parent_item'                => __('Parent Εκδότης', 'flynt'),
        'parent_item_colon'          => __('Parent Εκδότης:', 'flynt'),
        'new_item_name'              => __('New Εκδότης Name', 'flynt'),
        'add_new_item'               => __('Add New Εκδότης', 'flynt'),
        'edit_item'                  => __('Edit Εκδότης', 'flynt'),
        'update_item'                => __('Update Εκδότης', 'flynt'),
        'view_item'                  => __('View Εκδότης', 'flynt'),
        'separate_items_with_commas' => __('Separate Εκδότης with commas', 'flynt'),
        'add_or_remove_items'        => __('Add or remove Εκδότης', 'flynt'),
        'choose_from_most_used'      => __('Choose from the most used', 'flynt'),
        'popular_items'              => __('Popular Εκδότης', 'flynt'),
        'search_items'               => __('Search Εκδότης', 'flynt'),
        'not_found'                  => __('Not Found', 'flynt'),
        'no_terms'                   => __('No Τύπος', 'flynt'),
        'items_list'                 => __('Εκδότης list', 'flynt'),
        'items_list_navigation'      => __('Τύπος list navigation', 'flynt'),
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    ];

    register_taxonomy('ekdotes', ['product'], $args);  
    
    $labels = [
        'name'                       => _x('Εκπτώσεις', 'Έκπτωση General Name', 'flynt'),
        'singular_name'              => _x('Έκπτωση', 'Έκπτωση Singular Name', 'flynt'),
        'menu_name'                  => __('Έκπτωση', 'flynt'),
        'all_items'                  => __('All Έκπτωση', 'flynt'),
        'parent_item'                => __('Parent Έκπτωση', 'flynt'),
        'parent_item_colon'          => __('Parent Έκπτωση:', 'flynt'),
        'new_item_name'              => __('New Έκπτωση Name', 'flynt'),
        'add_new_item'               => __('Add New Έκπτωση', 'flynt'),
        'edit_item'                  => __('Edit Έκπτωση', 'flynt'),
        'update_item'                => __('Update Έκπτωση', 'flynt'),
        'view_item'                  => __('View Έκπτωση', 'flynt'),
        'separate_items_with_commas' => __('Separate Έκπτωση with commas', 'flynt'),
        'add_or_remove_items'        => __('Add or remove Έκπτωση', 'flynt'),
        'choose_from_most_used'      => __('Choose from the most used', 'flynt'),
        'popular_items'              => __('Popular Έκπτωση', 'flynt'),
        'search_items'               => __('Search Έκπτωση', 'flynt'),
        'not_found'                  => __('Not Found', 'flynt'),
        'no_terms'                   => __('No Έκπτωση', 'flynt'),
        'items_list'                 => __('Έκπτωση list', 'flynt'),
        'items_list_navigation'      => __('Έκπτωση list navigation', 'flynt'),
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    ];

    register_taxonomy('ekptoseis', ['product'], $args);    

});


add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
        
function woocommerce_ajax_add_to_cart() {
    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX :: get_refreshed_fragments();
    } else {
        $data = [
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
        ];

        echo wp_send_json($data);
    }

    wp_die();
}

// woo add to cart ajax result customize
// we have to use this ajax add to cart
add_filter( 'woocommerce_add_to_cart_fragments', 'mieteshop_header_top_cart_fragments', 10, 1 );
function mieteshop_header_top_cart_fragments( $fragments ) {
    $cart_list = [];
    foreach(WC()->cart->get_cart() as $cart_item){
        $authorIDs = get_field('book_contributors_syggrafeas', $cart_item['data']->get_id());
        $author_list = [];

        if( !empty($authorIDs) ){
            if( count($authorIDs) > 3 ){
                $author_list = 'Συλλογικό Έργο';
            } else {
                foreach( $authorIDs as $authorID ){
                    $author_list[] = [
                        'link' => get_permalink($authorID),
                        'title' => get_the_title($authorID)
                    ];
                }
            }
        }

        $wpimage = wp_get_attachment_image_src( get_post_thumbnail_id( $cart_item['data']->get_id() ), 'full' );
        
        if($wpimage) { 
            $image = $wpimage;  
        } else { 
            $image = array(''.include get_template_directory() . '/assets/images/header-cart-placeholder.png'.'','41','52'); 
        }   
        
        $cart_list[] = [
            'title' => $cart_item['data']->get_title(),
            'quantity' => $cart_item['quantity'],
            'price' =>  $cart_item['data']->get_price_html(),
            'placeholder' => placeholderImage($image[1], $image[2]),
            'image' => aq_resize($image[0], $image[1], $image[2], true),
            'authors' => $author_list,
        ];
    }
 
    global $twig;

    if( WC()->cart->get_cart_contents_count() == 0 ){
        $fragments['div#js-header-top-cart-list'] = '<div id="js-header-top-cart-list">Το καλάθι σας είναι άδειο</div>'; 
        $fragments['span#js-header-top-cart-number'] = '<span id="js-header-top-cart-number" class="header-top-cart-number"></span>';
    } else {
        $fragments['div#js-header-top-cart-list'] = $twig->render('header-top-cart-list.twig', ['cart_list' => $cart_list, 'cart_total' => WC()->cart->get_cart_total(), 'cat_page_url' => wc_get_cart_url()]);
        $fragments['span#js-header-top-cart-number'] = '<span id="js-header-top-cart-number" class="header-top-cart-number"><span>' . WC()->cart->get_cart_contents_count() . '</span></span>';
    }

    return $fragments;
}


// change Return to shop url to homepage                
add_filter( 'woocommerce_return_to_shop_redirect', 'st_woocommerce_shop_url' );
function st_woocommerce_shop_url(){
    return site_url();
}

/* change availability text */
add_filter( 'woocommerce_get_availability', 'pro_custom_get_availability', 1, 2);
function pro_custom_get_availability( $availability, $_product ) {
    // Change In Stock Text
    if ( $_product->is_in_stock() ) {
        $availability['availability'] = __('Άμεσα διαθέσιμο', 'woocommerce');
    }
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = __('Προσωρινά μη διαθέσιμο', 'woocommerce');
    }
    return $availability;
}

/* custom track product cookie for woocommerce_recently_viewed */
function custom_track_product_view() {
    if ( ! is_singular( 'product' ) ) {
        return;
    }
    
    global $post;
    
    if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) )
        $viewed_products = array();
    else
        $viewed_products = (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] );
    
        if ( ! in_array( $post->ID, $viewed_products ) ) {
        $viewed_products[] = $post->ID;
    }
    
    if ( sizeof( $viewed_products ) > 15 ) {
        array_shift( $viewed_products );
    }
    
    // Store for session only
    wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}
add_action( 'template_redirect', 'custom_track_product_view', 20 );


/* code by daphne */
/*
function woocommerce_sale_flash_from_woo_discount_rules_v2($html, $post, $product){
    $discounted_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price', $product->get_price(), $product, 1, 0, 'discounted_price', true);
    $wooco_discounted_price = $product->get_sale_price();

    if($discounted_price !== false){
        $html = '<span class="onsale">WooDiscountRules Discount</span>';
    }
    else if ($wooco_discounted_price > 0)
    {
        $max_percentage = ( ( $product->get_regular_price() - $wooco_discounted_price ) / $product->get_regular_price() ) * 100;
        $html = '<span class="onsale">-' . round($max_percentage) . '%' . '</span>';
    }

    return $html;
}
add_filter( 'woocommerce_sale_flash', 'woocommerce_sale_flash_from_woo_discount_rules_v2', 101, 3);
*/

/*
add_filter( 'woocommerce_get_price_html', 'change_displayed_sale_price_html', 10, 2 );
function change_displayed_sale_price_html( $price, $product ) {

    //Since rules are applied during runtime, we need to use filters to get Woo Discount Rules discount price - if any - 
	///$discounted_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price', false, $product, 1, 0, 'all', true);
	$discounted_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price', $product->get_price(), $product, 1, 0, 'discounted_price', true);

    // Only on sale products on frontend and excluding min/max price on variable products
    if( ! is_admin() && ! $product->is_type('variable') ) {
        if ( $discounted_price > 0) {            
            // Get product prices
            $regular_price = (float) $product->get_regular_price(); // Regular price
            //$discounted_price = (float) $discounted_price;
            echo $discounted_price['discounted_price'] .' >> ';

            // "Saving Percentage" calculation and formatting
            //$precision = 1; // Max number of decimals
            $saving_percentage = round( 100 - ( $discounted_price['discounted_price'] / $regular_price * 100 ), 1 ) . '%';

            // Append to the formated html price
            $price .= sprintf( __('<p class="book-product-discount">D: %s</p>', 'woocommerce' ), $saving_percentage );
        } elseif( $product->is_on_sale() ) {            
            // Get product prices
            $regular_price = (float) $product->get_regular_price(); // Regular price
            $sale_price = (float) $product->get_price(); // Active price (the "Sale price" when on-sale)
            echo $sale_price .' >> ';

            // "Saving Percentage" calculation and formatting
            //$precision = 1; // Max number of decimals
            $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';

            // Append to the formated html price
            $price .= sprintf( __('<p class="book-product-discount">S: %s</p>', 'woocommerce' ), $saving_percentage );
        }
    }    
    return $price;
}
*/


function woocommerce_discount_from_woo_discount_rules_v2($price, $product){ 
    $discounted_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price_from_custom_price', $product->get_price(), $product, 1, 0, 'discounted_price', true); 
    $wooco_discounted_price = $product->get_sale_price(); 
    $regular_price = (float) $product->get_regular_price(); // Regular price
    $sale_price = (float) $product->get_price(); // Active price (the "Sale price" when on-sale)
    
    if($discounted_price !== false){ 
        //$saving_percentage = round (( ( $product->get_price() - $discounted_price ) / $product->get_price() ) * 100, 1); 
        $saving_percentage = round( 100 - ( $discounted_price / $regular_price * 100 ), 1 ) . '%';
        $price .= sprintf( __('<p class="book-product-discount">%s</p>', 'woocommerce' ), $saving_percentage );
    } else if ($wooco_discounted_price > 0) { 
        //$saving_percentage = ( ( $product->get_regular_price() - $wooco_discounted_price ) / $product->get_regular_price() ) * 100; 
        $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';
        $price .= sprintf( __('<p class="book-product-discount">%s</p>', 'woocommerce' ), $saving_percentage );
    } 
    
    return $price; 
} 
add_filter( 'woocommerce_get_price_html', 'woocommerce_discount_from_woo_discount_rules_v2', 101, 3);


/*
// NOT WORKING BECAUSE IT GIVES AJAX ERROR 500 ON TRYING TO ADD OR REMOVE FROM CART
function hide_courier_when_free_is_available( $rates, $package ) {
    // Only modify rates if free_shipping is present.
    if ( isset( $rates['free_shipping:3'] ) ) {
        unset($rates['flat_rate:1']); // Remove the elta courier method
    }
	return $rates;
}
add_filter( 'woocommerce_package_rates', 'hide_courier_when_free_is_available', 100 );
*/

/**
 * Hide shipping rates when free shipping is available, but keep "Local pickup" 
 * Updated to support WooCommerce 2.6 Shipping Zones
 */
/*
function hide_shipping_when_free_is_available( $rates, $package ) {
	$new_rates = array();
	foreach ( $rates as $rate_id => $rate ) {
		// Only modify rates if free_shipping is present.
		if ( 'free_shipping' === $rate->method_id ) {
			$new_rates[ $rate_id ] = $rate;
			break;
		}
	}

	if ( ! empty( $new_rates ) ) {
		//Save local pickup if it's present.
		foreach ( $rates as $rate_id => $rate ) {
			if ('local_pickup' === $rate->method_id ) {
				$new_rates[ $rate_id ] = $rate;
				break;
			}
		}
		return $new_rates;
	}

	return $rates;
}
add_filter( 'woocommerce_package_rates', 'hide_shipping_when_free_is_available', 10, 2 );
*/

//shipping address closed by default
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );

// fix cart product thumbnail tht appeared cut off
function woocommerce_cart_item_thumbnail_2912067($image, $cartItem, $cartItemKey)
{
    $id = ($cartItem['variation_id'] !== 0 ? $cartItem['variation_id'] : $cartItem['product_id']);
    return wp_get_attachment_image(get_post_thumbnail_id((int) $id), 'medium');
}
add_filter('woocommerce_cart_item_thumbnail', 'woocommerce_cart_item_thumbnail_2912067', 10, 3);


// Woocommerce - Cart page notification for free shipping over 30 euros
add_action( 'woocommerce_before_cart_table', 'cart_page_notice' ); 
function cart_page_notice() {
    $min_amount = get_free_shipping_minimum( 'Ελλάδα' );
	//$min_amount = 30; //This is the amount of your free shipping threshold. Change according to your free shipping settings
	$current = WC()->cart->subtotal;
	if ( $current < $min_amount ) {
		$added_text = '<div class="woocommerce-message free-shipping-notification">Χρειάζεστε άλλα ' . wc_price( $min_amount - $current ) . ' για να έχετε δωρεάν μεταφορικά<br/>'; // This is the message shown on the cart page
		$return_to = wc_get_page_permalink( 'shop' );
		$notice = sprintf( '%s<a href="%s">%s</a>', $added_text, home_url(), 'Συνέχεια αγορών</div>' ); // This is the text shown below the notification. Link redirects to the shop page
		echo $notice;
	}
}

/**
 * Accepts a zone name and returns its threshold for free shipping.
 *
 * @param $zone_name The name of the zone to get the threshold of. Case-sensitive.
 * @return int The threshold corresponding to the zone, if there is any. If there is no such zone, or no free shipping method, null will be returned.
 */
function get_free_shipping_minimum($zone_name = 'England') {
    if ( ! isset( $zone_name ) ) return null;
  
    $result = null;
    $zone = null;
  
    $zones = WC_Shipping_Zones::get_zones();
    foreach ( $zones as $z ) {
      if ( $z['zone_name'] == $zone_name ) {
        $zone = $z;
      }
    }
  
    if ( $zone ) {
      $shipping_methods_nl = $zone['shipping_methods'];
      $free_shipping_method = null;
      foreach ( $shipping_methods_nl as $method ) {
        if ( $method->id == 'free_shipping' ) {
          $free_shipping_method = $method;
          break;
        }
      }
  
      if ( $free_shipping_method ) {
        $result = $free_shipping_method->min_amount;
      }
    }
  
    return $result;
  }


/**
 * Add custom gateway icons
*/
function custom_wc_gateway_icons( $icon, $gateway_id ) {
	if ( 'simplify_commerce' == $gateway_id ) {
		$icon = '<div class="simplify-icons"><img src="https://mietbookstore.gr/wp-content/themes/mieteshop/assets/images/simplify-bank-cards-banner.png" alt="' . __( 'Simplify' ) . '" /></div>';
	}
	return $icon;
}
add_filter( 'woocommerce_gateway_icon', 'custom_wc_gateway_icons', 10, 2 );  