<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="facebook-domain-verification" content="azmqa001a59sz9ji3d03m5dt25wdba" />
<title>
<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	//bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		echo " | $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		/* translators: %s: Page number. */
		echo esc_html( ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) ) );
	}

?>
</title>
<link rel="profile" href="https://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_head();

	$our_bookstores_url = get_field('header_our_bookstores_url', 'option');
?>

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '401444411870205');
fbq('track', 'PageView');
fbq('track', 'AddToCart');
fbq('track', 'AddToWishlist');
fbq('track', 'CompleteRegistration');
fbq('track', 'Purchase', {value: 0.00, currency: 'EUR'});
fbq('track', 'Search');
fbq('track', 'ViewContent');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=401444411870205&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<section class="pre-header">
	<div class="general-container">
		<div class="pre-header-row">
			<div class="pre-header-col">
				<div class="pre-header-item"><span class="pre-header-item-icon pre-header-item-icon--bus"><?php include get_template_directory() . '/assets/icons/bus-icon.svg' ?></span>Δωρεάν μεταφορικά και δωρεάν αντικαταβολή από 30€</div>
			</div>
			<div class="pre-header-col">
				<div class="pre-header-item"><span class="pre-header-item-icon pre-header-item-icon--calendar"><?php include get_template_directory() . '/assets/icons/calendar-icon.svg' ?></span>Αποστολή εντός 3 ημερών</div>
			</div>
			<div class="pre-header-col">
				<div class="pre-header-item"><a href="tel:2103614143"><span class="pre-header-item-icon pre-header-item-icon--phone"><?php include get_template_directory() . '/assets/icons/phone-icon.svg' ?></span>210 3614143</a></div>
			</div>
			<div class="pre-header-col">
				<div class="pre-header-item"><span class="pre-header-item-icon pre-header-item-icon--store"><?php include get_template_directory() . '/assets/icons/store-icon.svg' ?><a href="<?php echo $our_bookstores_url; ?>"></span>Τα βιβλιοπωλεία μας</a></div>
			</div>
			<div class="pre-header-col">
				<div class="pre-header-social-row">
					<div class="pre-header-social-col">
						<a href="<?php echo get_field('youtube_url', 'option'); ?>" target="_blank"><div class="pre-header-social-icon pre-header-social-icon--youtube"><?php include get_template_directory() . '/assets/icons/youtube-icon.svg' ?></div></a>
					</div>
					<div class="pre-header-social-col">
						<a href="<?php echo get_field('sound_cloude_url', 'option'); ?>" target="_blank"><div class="pre-header-social-icon pre-header-social-icon--sound-cloude"><?php include get_template_directory() . '/assets/icons/sound-cloude-icon.svg' ?></div></a>
					</div>
					<div class="pre-header-social-col">
						<a href="<?php echo get_field('facebook_url', 'option'); ?>" target="_blank"><div class="pre-header-social-icon pre-header-social-icon--facebook"><?php include get_template_directory() . '/assets/icons/facebook-icon.svg' ?></div></a>
					</div>
					<div class="pre-header-social-col">
						<a href="<?php echo get_field('instagram_url', 'option'); ?>" target="_blank"><div class="pre-header-social-icon pre-header-social-icon--instagram"><?php include get_template_directory() . '/assets/icons/instagram-icon.svg' ?></div></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<header class="site-header">
	<div class="header-top">
		<div class="container">
			<div class="header-top-row">
				<div id="js-header-top-mobile-menu-btn" class="header-top-mobile-menu-btn">
					<span></span>
				</div>
				<div class="header-top-left">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php include get_template_directory() . '/assets/icons/home-icon.svg' ?></a>
				</div>
				<div class="header-top-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">ΒΙΒΛΙΟΠΩΛΕΙΟ ΜΙΕΤ</a>
				</div>
				<div id="js-header-top-right" class="header-top-right">
					<div class="header-top-right-row">
						<div class="header-top-right-col">
							<div class="header-top-search-wrapper">
								<div id="js-header-top-search-icon" class="header-top-search-icon">
									<?php include get_template_directory() . '/assets/icons/search-icon.svg' ?>
								</div>
								<div id="js-header-top-search-popup" class="header-top-search-popup">
									<div id="js-header-top-search-form" class="header-top-search-form">
										<input type="text" id="js-header-top-search-form-text" placeholder="αναζήτηση" data-nonce="<?php echo wp_create_nonce('header_top_search_nonce'); ?>">
									</div>
									<?php
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( 3401 ), 'full' );
									?>
									<div id="js-header-top-search-result-group-wrapper"></div>
								</div>
							</div>
						</div>
						<div class="header-top-right-col">
							<div class="header-top-search-wrapper">
								<?php
									if ( is_active_sidebar( 'widget-area-only-for-header-wishlist-items' ) ){
										dynamic_sidebar( 'widget-area-only-for-header-wishlist-items' );
									}
								?>
							</div>
						</div>
						<div class="header-top-right-col">
							<div class="header-top-search-wrapper">
								<div id="js-header-top-user-icon" class="header-top-search-icon">
									<?php include get_template_directory() . '/assets/icons/user-icon.svg' ?>
								</div>
								<div id="js-header-top-user-popup" class="header-top-search-popup header-top-search-popup--user">
									<div class="header-top-search-result-menu">
										<div class="header-top-search-result-menu-title">
											<h3>ΛΟΓΑΡΙΑΣΜΟΣ</h3>
										</div>
										<div class="header-top-search-result-menu-list">
											<ul>
												<?php
													if( is_user_logged_in() ){
												?>
														<li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">Ο λογαριασμός μου</a></li>
														<li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>/orders">Ιστορικό αγορών</a></li>
														<li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>/edit-account/">Ρυθμίσεις</a></li>
														<li><a href="<?php echo is_user_logged_in() ? wc_logout_url() : get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">Έξοδος / Log out</a></li>
												<?php
													} else {
												?>
														<li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">Σύνδεση/Εγγραφή</a></li>
												<?php
													}
												?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="header-top-right-col">
							<div class="header-top-search-wrapper">
								<div id="js-header-top-busket-icon" class="header-top-search-icon">
									<span id="js-header-top-cart-number" class="header-top-cart-number">
										<?php
											if( WC()->cart->get_cart_contents_count() > 0 ){
										?>
												<span><?php echo WC()->cart->get_cart_contents_count(); ?></span>
										<?php
											}
										?>
									</span>
									<?php include get_template_directory() . '/assets/icons/busket-icon.svg' ?>
								</div>
								<div id="js-header-top-busket-popup" class="header-top-search-popup header-top-search-popup--busket">
									<?php
										// check cart is not empty
										if( WC()->cart->get_cart_contents_count() == 0 ){
									?>
											<div id="js-header-top-cart-list">Το καλάθι σας είναι άδειο</div> 
									<?php
										} else {
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

												$image = wp_get_attachment_image_src( get_post_thumbnail_id( $cart_item['data']->get_id() ), 'full' );

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
									?>
											<div id="js-header-top-cart-list">
												<?php echo $twig->render('header-top-cart-list.twig', ['cart_list' => $cart_list, 'cart_total' => WC()->cart->get_cart_total(), 'cat_page_url' => wc_get_cart_url()]); ?>
											</div>
									<?php
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<nav id="js-header-nav" class="header-nav">
		<div class="container">
			<?php
				$locations = get_nav_menu_locations();
				$header_menu_array = wp_get_menu_array($locations['header_menu']);
			?>
			<div class="header-nav-row">
				<?php
					foreach( $header_menu_array as $menu ){
				?>
						<div class="header-nav-col <?php echo $menu['has_child'] ? 'header-nav-col--has-child js-header-nav-parent-menu' : ''; ?>" data-menu-id="<?php echo $menu['ID']; ?>">
							<a href="<?php echo $menu['url'] ?>" class="<?php //echo $menu['has_child'] ? 'js-header-nav-parent-menu' : 'js-header-nav-menu'; ?> <?php echo $menu['class']; ?>" ><?php echo $menu['title']; ?></a>
							<?php
								if( $menu['has_child'] ){
							?>
									<span class="header-nav-desktop-arrow"><?php include get_template_directory() . '/assets/icons/arrow-down-icon.svg'; ?></span>
									<div class="js-header-nav-mobile-arrow-wrapper header-nav-mobile-arrow-wrapper">
										<span class="header-nav-mobile-arrow"><?php include get_template_directory() . '/assets/icons/arrow-down-icon.svg'; ?></span>
									</div>
									<div class="js-header-nav-mobile-sub-wrapper header-nav-mobile-sub-wrapper">
										<?php
											foreach( $menu['children'] as $sub_menu_wrapper ){
												foreach( $sub_menu_wrapper['children'] as $sub_menu ){
										?>
													<div class="header-nav-mobile-sub">
														<a href="<?php echo $sub_menu['url'] ?>"><?php echo $sub_menu['title']; ?></a>
														<?php
															if( $sub_menu['has_child'] ){
														?>
																<div class="js-header-nav-mobile-sub-arrow-wrapper header-nav-mobile-sub-arrow-wrapper">
																	<span class="header-nav-mobile-sub-arrow"><?php include get_template_directory() . '/assets/icons/arrow-down-icon.svg'; ?></span>
																</div>
																<div class="js-header-nav-mobile-sub-sub-wrapper header-nav-mobile-sub-sub-wrapper">
																	<?php
																		foreach( $sub_menu['children'] as $sub_sub_menu ){
																	?>
																			<div class="header-nav-mobile-sub-sub">
																				<a href="<?php echo $sub_sub_menu['url']; ?>"><?php echo $sub_sub_menu['title']; ?></a>
																			</div>
																	<?php
																		}
																	?>
																</div>
														<?php
															}
														?>
													</div>
										<?php
												}
											}
										?>
									</div>
							<?php
								}
							?>
						</div>
				<?php
					}
				?>
				<?php
					foreach( $header_menu_array as $menu ){
						if( $menu['has_child'] && get_field('sub_menu_row', $menu['ID']) ){
				?>
							<div id="header-sub-menu-<?php echo $menu['ID']; ?>" class="header-sub-menu">
								<div class="header-sub-menu-inner">
									<div class="header-sub-menu-row">
										<?php
											foreach( $menu['children'] as $sub_menu_wrapper ){
												if( get_field('sub_menu_col', $sub_menu_wrapper['ID']) ){
										?>
													<div class="header-sub-menu-col">
														<?php
															foreach( $sub_menu_wrapper['children'] as $sub_menu ){
														?>
																<div class="header-sub-menu-item">
																	<a href="<?php echo $sub_menu['url'] ?>" class="<?php echo $sub_menu['class']; ?>"><?php echo $sub_menu['title']; ?></a>
																	<?php
																		if( $sub_menu['has_child'] ){
																	?>
																			<div class="header-sub-sub-menu">
																				<?php
																					foreach( $sub_menu['children'] as $sub_sub_menu ){
																				?>
																						<div class="header-sub-sub-menu-col">
																							<a href="<?php echo $sub_sub_menu['url']; ?>" class="<?php echo $sub_sub_menu['class']; ?>"><?php echo $sub_sub_menu['title']; ?></a>
																						</div>
																				<?php
																					}
																				?>
																			</div>
																	<?php
																		}
																	?>
																</div>
														<?php
															}
														?>
													</div>
										<?php
												}
											}
										?>
									</div>
									<div class="header-sub-menu-footer">
										<?php
											$link_1 = get_field('link_1', $menu['ID']);
											$link_2 = get_field('link_2', $menu['ID']);
										?>
										<div class="header-sub-menu-footer-left">
											<div class="header-sub-menu-footer-left-col">
												<a href="<?php echo $link_1['url']; ?>"><?php echo $link_1['title']; ?></a>
											</div>
											<div class="header-sub-menu-footer-left-col">
												<a href="<?php echo $link_2['url']; ?>"><?php echo $link_2['title']; ?></a>
											</div>
										</div>
										<div class="header-sub-menu-footer-right">
											<a href="<?php echo get_field('thematic_map_page', 'option'); ?>">ΑΝΑΛΥΤΙΚΟΣ ΘΕΜΑΤΙΚΟΣ ΧΑΡΤΗΣ</a>
										</div>
									</div>
								</div>
							</div>
				<?php
						}
					}
				?>
			</div>
			<div class="header-mobile-nav-row">
				<div class="header-mobile-nav-col header-mobile-nav-col--gray"><a href="#">ΝΕΕΣ ΚΥΚΛΟΦΟΡΙΕΣ</a></div>
				<div class="header-mobile-nav-col header-mobile-nav-col--gray"><a href="/seires-miet/">ΣΕΙΡΕΣ ΜΙΕΤ</a></div>
				<div class="header-mobile-nav-col header-mobile-nav-col--white"><a href="<?php echo get_field('thematic_map_page', 'option'); ?>">ΑΝΑΛΥΤΙΚΟΣ ΘΕΜΑΤΙΚΟΣ ΧΑΡΤΗΣ</a></div>
			</div>
		</div>
	</nav>
</header>