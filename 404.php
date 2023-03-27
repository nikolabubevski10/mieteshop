<?php
/**
 * Template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

	<div id="content-container" class="page-not-found">
		<div id="content" role="main">

			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'Η σελίδα δεν βρέθηκε', 'twentyten' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Λυπουμάστε αλλά η σελίδα δεν βρέθηκε. Μπορείτε να χρησιμοποιήσετε την αναζήτηση για να βρείτε αυτό που ψάχνετε.', 'twentyten' ); ?></p>
					<div class="entry-form"><?php get_search_form(); ?></div>
				</div><!-- .entry-content -->
			</div><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #container -->
	<script type="text/javascript">
		// Focus on search field after it has loaded.
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>
