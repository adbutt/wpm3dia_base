<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpm3dia_bas3
 */

?><!DOCTYPE html>
<!--[if lt IE 7]><html class="ie ie6 lt-ie10 lt-ie9 lt-ie8 lt-ie7 no-js" lang="en"><![endif]-->
<!--[if IE 7]><html class="ie ie7 lt-ie10 lt-ie9 lt-ie8 no-js" id="ie7" lang="en"><![endif]-->
<!--[if IE 8]><html class="ie ie8 lt-ie10 lt-ie9 no-js" id="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie lt-ie10 no-js" id="ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<title></title>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body itemscope itemtype="http://schema.org/WebPage" <?php body_class(); ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wpm3dia_bas3' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<div class="wrap header-wrap">
      <div class="site-branding">
  			<?php
  			if ( is_front_page() && is_home() ) : ?>
  				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
  			<?php else : ?>
  				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
  			<?php
  			endif;

  			$description = get_bloginfo( 'description', 'display' );
  			if ( $description || is_customize_preview() ) : ?>
  				<p class="site-description hyper"><?php echo $description; /* WPCS: xss ok. */ ?></p>
  			<?php
  			endif; ?>
  		</div><!-- .site-branding -->

  		<nav id="site-navigation" class="main-navigation" role="navigation">
  			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
  		</nav><!-- #site-navigation -->
      <div id="mobile-menu"></div>
      <!-- mobile extra-->
      <div class="header-mob">
        <a href="tel:0418652607" class="btn black">Call Now</a>
        <a href="#modal-enquire" class="btn orange">Enquire</a>
      </div>
    </div> 
	</header><!-- #masthead -->
	<div id="content" class="site-content">
