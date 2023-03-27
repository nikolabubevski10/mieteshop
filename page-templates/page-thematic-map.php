<?php
/**
 * Template Name: Thematic Map Page
 */
?>
<?php get_header(); ?>

<?php
	$root_cat_list = get_terms([
        'taxonomy' => 'product_cat', 
        'hide_empty' => false, 
		'parent' => 0,
		'orderby' => 'name',
		'order' => 'ASC'
	]);
?>
<section class="thematic-sub-menu-wrapper">
	<div class="thematic-sub-menu-row">
		<?php
			foreach($root_cat_list as $root_cat){
				$deep_2_cat_list = get_terms([
					'taxonomy' => 'product_cat', 
					'hide_empty' => false, 
					'parent' => $root_cat->term_id,
					'orderby' => 'name',
					'order' => 'ASC'
				]);
		?>
			<div class="thematic-sub-menu-col">
				<div class="header-sub-menu-item">
					<a href="<?php echo get_term_link($root_cat->term_id); ?>"><?php echo $root_cat->name; ?></a>
					<?php
						if( !empty($deep_2_cat_list) ){
					?>
							<div class="header-sub-sub-menu">
								<?php
									foreach($deep_2_cat_list as $deep_2_cat){
										$deep_3_cat_list = get_terms([
											'taxonomy' => 'product_cat', 
											'hide_empty' => false, 
											'parent' => $deep_2_cat->term_id,
											'orderby' => 'name',
											'order' => 'ASC'
										]);
								?>
										<div class="header-sub-sub-menu-col">
											<a href="<?php echo get_term_link($deep_2_cat->term_id); ?>"><?php echo $deep_2_cat->name; ?></a>
											<?php
												if( !empty($deep_3_cat_list) ){
											?>
													<div class="header-sub-sub-sub-menu">
														<?php
															foreach($deep_3_cat_list as $deep_3_cat){
														?>
																<div class="header-sub-sub-sub-menu-col">
																	<a href="<?php echo get_term_link($deep_3_cat->term_id); ?>"><?php echo $deep_3_cat->name; ?></a>
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
					?>
				</div>
			</div>
		<?php
			}
		?>
	</div>
</section>

<?php get_footer(); ?>