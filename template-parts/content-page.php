<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</div>

	<?php theme_get_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_content();?>
	</div>
</article>