<?php
/**
 * The template for displaying a header.
 *
 * @package Wonderpress Theme
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title(); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<link href="//www.google-analytics.com" rel="dns-prefetch">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">


	<?php
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );}
	?>

	<?php wp_head(); ?>

	<!-- analytics -->
	<script>
		(function(f, i, r, e, s, h, l) {
			i['GoogleAnalyticsObject'] = s;
			f[s] = f[s] || function() {
				(f[s].q = f[s].q || []).push(arguments)
			}, f[s].l = 1 * new Date();
			h = i.createElement(r),
				l = i.getElementsByTagName(r)[0];
			h.async = 1;
			h.src = e;
			l.parentNode.insertBefore(h, l)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
		ga('create', 'UA-XXXXXXXX-XX', 'auto');
		ga('send', 'pageview');
	</script>
</head>

<body id="<?php echo esc_attr( wonder_body_id() ); ?>" <?php body_class(); ?>>

	<header id="theme-header" class="theme-header clear" role="banner">
		<div class="container">

			<div class="theme-header-logo">
				<a href="<?php echo esc_url( home_url() ); ?>"></a>
			</div>

			<nav class="theme-header-nav hidden-xs" role="navigation">
				<?php wonder_nav( 'header-menu' ); ?>
			</nav>

			<a href="#" id="theme-header-hamburger" class="theme-header-hamburger visible-xs-block">
				<span class="theme-header-hamburger-bar"></span>
				<span class="theme-header-hamburger-bar"></span>
				<span class="theme-header-hamburger-bar"></span>
			</a>
		</div>
	</header>
