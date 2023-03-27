<?php
	if ( have_posts() ) {
		while ( have_posts() ) :
			the_post();
?>
			<section class="cart-page-title">
    			<div class="content-container">
					<h1><?php the_title(); ?></h1>
				</div>
			</section>
			<section class="cart-section">
    			<div class="content-container">
					<?php the_content(); ?>
				</div>
			</section>
<?php
		endwhile;
	}
?>
