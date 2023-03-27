<?php
/**
 * Wishlist page template - Standard Layout
 *
 * @author YITH
 * @package YITH\Wishlist\Templates\Wishlist\View
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist                      \YITH_WCWL_Wishlist Current wishlist
 * @var $wishlist_items                array Array of items to show for current page
 * @var $wishlist_token                string Current wishlist token
 * @var $wishlist_id                   int Current wishlist id
 * @var $users_wishlists               array Array of current user wishlists
 * @var $pagination                    string yes/no
 * @var $per_page                      int Items per page
 * @var $current_page                  int Current page
 * @var $page_links                    array Array of page links
 * @var $is_user_owner                 bool Whether current user is wishlist owner
 * @var $show_price                    bool Whether to show price column
 * @var $show_dateadded                bool Whether to show item date of addition
 * @var $show_stock_status             bool Whether to show product stock status
 * @var $show_add_to_cart              bool Whether to show Add to Cart button
 * @var $show_remove_product           bool Whether to show Remove button
 * @var $show_price_variations         bool Whether to show price variation over time
 * @var $show_variation                bool Whether to show variation attributes when possible
 * @var $show_cb                       bool Whether to show checkbox column
 * @var $show_quantity                 bool Whether to show input quantity or not
 * @var $show_ask_estimate_button      bool Whether to show Ask an Estimate form
 * @var $show_last_column              bool Whether to show last column (calculated basing on previous flags)
 * @var $move_to_another_wishlist      bool Whether to show Move to another wishlist select
 * @var $move_to_another_wishlist_type string Whether to show a select or a popup for wishlist change
 * @var $additional_info               bool Whether to show Additional info textarea in Ask an estimate form
 * @var $price_excl_tax                bool Whether to show price excluding taxes
 * @var $enable_drag_n_drop            bool Whether to enable drag n drop feature
 * @var $repeat_remove_button          bool Whether to repeat remove button in last column
 * @var $available_multi_wishlist      bool Whether multi wishlist is enabled and available
 * @var $no_interactions               bool
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<!-- WISHLIST TABLE -->
<table
	class="shop_table cart wishlist_table wishlist_view traditional responsive <?php echo $no_interactions ? 'no-interactions' : ''; ?> <?php echo $enable_drag_n_drop ? 'sortable' : ''; ?> "
	data-pagination="<?php echo esc_attr( $pagination ); ?>" data-per-page="<?php echo esc_attr( $per_page ); ?>" data-page="<?php echo esc_attr( $current_page ); ?>"
	data-id="<?php echo esc_attr( $wishlist_id ); ?>" data-token="<?php echo esc_attr( $wishlist_token ); ?>"
    cellspacing="0">

	<?php $column_count = 2; ?>

	<tbody class="wishlist-items-wrapper">
	<?php
	if ( $wishlist && $wishlist->has_items() ) :
		foreach ( $wishlist_items as $item ) :
			/**
			 * Each of the wishlist items
			 *
			 * @var $item \YITH_WCWL_Wishlist_Item
			 */
			global $product;

			$product      = $item->get_product();
			$availability = $product->get_availability();
			$stock_status = isset( $availability['class'] ) ? $availability['class'] : false;

            $authorIDs = get_field('book_contributors_syggrafeas', $item->get_product_id());

			if ( $product && $product->exists() ) :
				?>
				<tr id="yith-wcwl-row-<?php echo esc_attr( $item->get_product_id() ); ?>" data-row-id="<?php echo esc_attr( $item->get_product_id() ); ?>">

					<td class="cart-product-thumbnail">
						<?php do_action( 'yith_wcwl_table_before_product_thumbnail', $item, $wishlist ); ?>

						<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
							<?php echo wp_kses_post( $product->get_image() ); ?>
						</a>

						<?php do_action( 'yith_wcwl_table_after_product_thumbnail', $item, $wishlist ); ?>
					</td>

					<td class="cart-product-info">
                        <?php
                            if( !empty($authorIDs) ){
                                echo '<div class="cart-product-author-list">';
                                if( count($authorIDs) > 3 ){
                                    echo '<div class="cart-product-author-item">Συλλογικό Έργο</div>';
                                } else {
                                    foreach( $authorIDs as $authorID ){
                                        echo '<div class="cart-product-author-item"><a href="'. get_permalink($authorID) . '">' . get_the_title($authorID) . '</a></div>';
                                    }
                                }
                                echo '</div>';
                            }
                        ?>
                        <div class="cart-product-name">
                            <?php do_action( 'yith_wcwl_table_before_product_name', $item, $wishlist ); ?>

                            <a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
                                <?php echo wp_kses_post( apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ); ?>
                            </a>

                            <?php
                            if ( $show_variation && $product->is_type( 'variation' ) ) {
                                /**
                                 * Product is a Variation
                                 *
                                 * @var $product \WC_Product_Variation
                                 */
                                echo wp_kses_post( wc_get_formatted_variation( $product ) );
                            }
                            ?>

                            <?php do_action( 'yith_wcwl_table_after_product_name', $item, $wishlist ); ?>
                        </div>

                        <div class="pcat-result-item-footer-row pcat-result-item-footer-row-static">
                            <div class="pcat-result-item-footer-col">
                                <?php
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                ?>
                                <div class="pcat-result-item-footer-product-price price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                    <?php
                                        echo $product->get_price_html();
                                        /*
                                        if($sale_price > 0) {
                                            echo '<del>' . wc_price($regular_price) . '</del>';	
                                        }	
                                        echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                        */

                                    ?>
                                </div>
                            </div>
                            <div class="pcat-result-item-footer-col">
                                <?php  
                                //if($sale_price > 0) {
                                //$saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%'; 
                                ?>
                                <!--div class="pcat-result-item-footer-product-discount"><?php //echo $saving_percentage; ?></div-->
                                <?php //} ?>
                            </div>
                        </div>
                        <div class="cart-product-remove-btn product-remove">
                            <a href="<?php echo esc_url( $item->get_remove_url() ); ?>" class="remove remove_from_wishlist" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>"><span><?php echo file_get_contents(get_template_directory() . '/assets/icons/delete-icon.svg' ); ?></span>διαγραφή</a>
                        </div>
					</td>

					<td class="cart-product-status">
                        <div class="cart-product-status-label">κατάσταση</div>
                        <div class="cart-product-status-value">
                        <span>
                            <?php                                         
                                //echo $availability['availability'] .' - ' .$availability['class'] .'<br/>';
                                 if ($stock_status == 'out-of-stock') { echo 'εξαντλημένο'; } else { echo 'άμεσα διαθέσιμο'; } 
                            ?>
                        </span>
                        </div>
                    </td>

                    <td class="product-add-to-cart">
                        <?php do_action( 'yith_wcwl_table_before_product_cart', $item, $wishlist ); ?>

                        <!-- Date added -->
                        <?php
                        if ( $show_dateadded && $item->get_date_added() ) :
                            // translators: date added label: 1 date added.
                            echo '<span class="dateadded">' . esc_html( sprintf( __( 'Added on: %s', 'yith-woocommerce-wishlist' ), $item->get_date_added_formatted() ) ) . '</span>';
                        endif;
                        ?>

                        <?php do_action( 'yith_wcwl_table_product_before_add_to_cart', $item, $wishlist ); ?>

                        <!-- Add to cart button -->
                        <?php $show_add_to_cart = apply_filters( 'yith_wcwl_table_product_show_add_to_cart', $show_add_to_cart, $item, $wishlist ); ?>
                        <?php if ( $show_add_to_cart && isset( $stock_status ) && 'out-of-stock' !== $stock_status ) : ?>
                            <?php woocommerce_template_loop_add_to_cart( array( 'quantity' => $show_quantity ? $item->get_quantity() : 1 ) ); ?>
                        <?php endif ?>

                        <?php do_action( 'yith_wcwl_table_product_after_add_to_cart', $item, $wishlist ); ?>

                        <!-- Change wishlist -->
                        <?php $move_to_another_wishlist = apply_filters( 'yith_wcwl_table_product_move_to_another_wishlist', $move_to_another_wishlist, $item, $wishlist ); ?>
                        <?php if ( $move_to_another_wishlist && $available_multi_wishlist && count( $users_wishlists ) > 1 ) : ?>
                            <?php if ( 'select' === $move_to_another_wishlist_type ) : ?>
                                <select class="change-wishlist selectBox">
                                    <option value=""><?php esc_html_e( 'Move', 'yith-woocommerce-wishlist' ); ?></option>
                                    <?php
                                    foreach ( $users_wishlists as $wl ) :
                                        /**
                                         * Each of customer's wishlists
                                         *
                                         * @var $wl \YITH_WCWL_Wishlist
                                         */
                                        if ( $wl->get_token() === $wishlist_token ) {
                                            continue;
                                        }
                                        ?>
                                        <option value="<?php echo esc_attr( $wl->get_token() ); ?>">
                                            <?php echo sprintf( '%s - %s', esc_html( $wl->get_formatted_name() ), esc_html( $wl->get_formatted_privacy() ) ); ?>
                                        </option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            <?php else : ?>
                                <a href="#move_to_another_wishlist" class="move-to-another-wishlist-button" data-rel="prettyPhoto[move_to_another_wishlist]">
                                    <?php echo esc_html( apply_filters( 'yith_wcwl_move_to_another_list_label', __( 'Move to another list &rsaquo;', 'yith-woocommerce-wishlist' ) ) ); ?>
                                </a>
                            <?php endif; ?>

                            <?php do_action( 'yith_wcwl_table_product_after_move_to_another_wishlist', $item, $wishlist ); ?>

                        <?php endif; ?>

                        <!-- Remove from wishlist -->
                        <?php if ( $repeat_remove_button ) : ?>
                            <a href="<?php echo esc_url( $item->get_remove_url() ); ?>" class="remove_from_wishlist button" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>"><?php esc_html_e( 'Remove', 'yith-woocommerce-wishlist' ); ?></a>
                        <?php endif; ?>

                        <?php do_action( 'yith_wcwl_table_after_product_cart', $item, $wishlist ); ?>
                    </td>
				</tr>
				<?php
			endif;
		endforeach;
	else :
		?>
		<tr>
			<td colspan="<?php echo esc_attr( $column_count ); ?>" class="wishlist-empty"><?php echo esc_html( apply_filters( 'yith_wcwl_no_product_to_remove_message', __( 'No products added to the wishlist', 'yith-woocommerce-wishlist' ), $wishlist ) ); ?></td>
		</tr>
		<?php
	endif;

	if ( ! empty( $page_links ) ) :
		?>
		<tr class="pagination-row wishlist-pagination">
			<td colspan="<?php echo esc_attr( $column_count ); ?>">
				<?php echo wp_kses_post( $page_links ); ?>
			</td>
		</tr>
	<?php endif ?>
	</tbody>

</table>
