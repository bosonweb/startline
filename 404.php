<?php get_header(); ?>

<div class="container">

	<div class="page-header">
		<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.'); ?></h1>
	</div>

	<div class="page-content">
		<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?'); ?></p>

		<?php get_search_form(); ?>
	</div>

</div>

<?php get_footer(); ?>
