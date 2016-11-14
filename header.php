<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/manifest.json">
	<link rel="mask-icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#c25cc3">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div class="container">
		<header class="site-header" role="banner">
			<div class="jumbotron">
				<h1>Startline</h1>
				<p>O Captain! my Captain! rise up and hear the bells; <br>
					Rise up—for you the flag is flung—for you the bugle trills</p>
			</div>
			<?php wp_nav_menu(array('container_class' => '',
										'menu_class' => 'nav nav-pills'));?>
		</header>
	</div>