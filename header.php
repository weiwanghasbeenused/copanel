<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package copanel
 */
$current_lang = get_bloginfo('language');
$isZh_tw = false;
$isEn_us = false;
$isZh_cn = false;

switch( $current_lang ){
	case 'zh-TW':
		$isZh_tw = true;
		break;
	case 'zh-CN':
		$isZh_cn = true;
		break;
	case 'en-US':
		$isEn_us = true;
		break;
}
// die();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-166304494-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-166304494-1');
	</script>
	<!-- Global site tag (gtag.js) - Google Ads: 636060130 -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-636060130"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'AW-636060130');
	</script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'copanel' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$copanel_description = get_bloginfo( 'description', 'display' );
			if ( $copanel_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $copanel_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<div id = "logo">
				<a href = "<?php echo esc_url( home_url( '/' ) ); ?>"><img src = "<?php echo get_site_url(); ?>/wp-content/uploads/2020/03/Copanel-Logo-Black-250x68-1.png"></a>
			</div>
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<div class = "menu_bar"></div>
				<div class = "menu_bar"></div>
				<div class = "menu_bar"></div>
			</button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
