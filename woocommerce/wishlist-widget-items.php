<?php
/**
 * Wishlist items widget
 *
 * @author YITH
 * @package YITH\Wishlist\Templates\Wishlist\View
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $before_widget          string HTML to print before widget
 * @var $after_widget           string HTML to print after widget
 * @var $instance               array Array of widget options
 * @var $products               array Array of items that were added to lists; each item refers to a product, and contains product object, wishlist items, and quantity count
 * @var $items                  array Array of raw items
 * @var $wishlist_url           string Url to wishlist page
 * @var $multi_wishlist_enabled bool Whether MultiWishlist is enabled or not
 * @var $default_wishlist       YITH_WCWL_Wishlist Default list
 * @var $add_all_to_cart_url    string Url to add all items to cart
 * @var $fragments_options      array Array of options to be used for fragments generation
 * @var $heading_icon           string Heading icon HTML tag
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php echo apply_filters( 'yith_wcwl_before_wishlist_widget', $before_widget ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

	<div
		class="content <?php echo esc_attr( $instance['style'] ); ?> yith-wcwl-items-<?php echo esc_html( $instance['unique_id'] ); ?> woocommerce wishlist-fragment on-first-load"
		data-fragment-options="<?php echo wc_esc_json( wp_json_encode( $fragments_options ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>"
	>

		<div id="js-header-top-favorite-icon" class="header-top-search-icon">
			<?php include get_template_directory() . '/assets/icons/favorite-icon.svg' ?>
			<?php
				if ( ! $instance['ajax_loading'] && !empty( $products ) ){
			?>
					<span class="header-top-cart-number"><span><?php echo esc_html( count( $products ) ); ?></span></span>
			<?php
				}
			?>
		</div>

		<div id="js-header-top-favorite-popup" class="header-top-search-popup header-top-search-popup--favorite">
			<?php
				if ( ! $instance['ajax_loading'] && ! empty( $products ) ){
			?>
					<div class="header-top-search-result-group-list">
						<div class="header-top-search-result-group header-top-search-result-group--favorite">
							<div class="header-top-search-result-group-title">
								<h3>ΑΓΑΠΗΜΕΝΑ</h3>
							</div>
							<?php
								foreach ( $products as $product_id => $info ){
									$product = $info['product'];

									$authorIDs = get_field('book_contributors_syggrafeas', $product_id);
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

									$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'full' );
							?>
									<div class="header-top-search-result-item">
										<div class="header-top-search-result-item-row">
											<div class="header-top-search-result-item-left-col">
												<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'remove_from_wishlist', $product_id ), 'remove_from_wishlist' ) ); ?>" class="remove_from_all_wishlists" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-wishlist-id="<?php echo 'yes' === $instance['show_default_only'] ? esc_attr( $default_wishlist->get_id() ) : ''; ?>" style="display: none;">&times;</a>
												<div class="header-top-search-result-item-image">
													<img
														class="lazyload"
														src="<?php echo placeholderImage($image[1], $image[2]); ?>"
														data-src="<?php echo aq_resize($image[0], $image[1], $image[2], true); ?>"
														alt="product-image">
												</div>
											</div>
											<div class="header-top-search-result-item-right-col">
												<div class="header-top-search-result-item-info">
													<div class="header-top-search-result-item-info-author">Δημήτριος Ι. Ζέπος</div>
													<div class="header-top-search-result-item-info-title">
														<h4><?php echo esc_html( $product->get_title() ); ?></h4>
													</div>
												</div>
											</div>
										</div>
									</div>
							<?php
								}
							?>
						</div>
					</div>
			<?php
				} else {
			?>
					<?php echo esc_html( apply_filters( 'yith_wcwl_widget_items_empty_list', __( 'Please, add your first item to the wishlist', 'yith-woocommerce-wishlist' ) ) ); ?>
			<?php
				}
			?>
			
			<?php
				if ( count( $products ) && 'yes' === $instance['show_view_link'] ){
			?>
					<div class="header-top-search-button">
						<a class="show-wishlist" href="<?php echo esc_url( $wishlist_url ); ?> "><?php esc_html_e( 'View your wishlist &rsaquo;', 'yith-woocommerce-wishlist' ); ?></a>
					</div>
			<?php
				}
			?>
		</div>
	</div>

<?php echo apply_filters( 'yith_wcwl_after_wishlist_widget', $after_widget ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
