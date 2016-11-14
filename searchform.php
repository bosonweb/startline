<form role="search" method="get" class="form-inline search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="form-group">
		<label>
			<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label'); ?></span>
		</label>
		<input type="search" class="form-control search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</div>
	<button type="submit" class="btn btn-default btn-search-submit"><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button'); ?></span></button>
</form>
