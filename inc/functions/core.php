<?php
namespace WPM3dia\wpm3dia_bas3\Core;

/**
 * Set up theme defaults and register supported WordPress features.
 *
 * @since 0.1.0
 *
 * @uses add_action()
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'after_setup_theme',  $n( 'i18n' )        );
  add_action( 'after_setup_theme',  $n( 'wpm3dia_head_setup' ) );
	add_action( 'after_setup_theme',  $n( 'register_defaults' ) );
	add_action( 'widgets_init', 	  $n( 'wpm3dia_bas3_widgets_init' ) );
	add_action( 'wp_head',            $n( 'header_meta' ) );
	add_action( 'wp_enqueue_scripts', $n( 'scripts' )     );
	add_action( 'wp_enqueue_scripts', $n( 'styles' )      );
}

/**
 * Makes WP Theme available for translation.
 *
 * Translations can be added to the /lang directory.
 * If you're building a theme based on WP Theme, use a find and replace
 * to change 'wptheme' to the name of your theme in all template files.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 *
 * @since 0.1.0
 *
 * @return void
 */
function i18n() {
	load_theme_textdomain( 'wpm3dia_bas3_', WPMBASE__PATH . '/languages' );
 }


//remove all the bumph from the header
function wpm3dia_head_setup () {
  remove_action('wp_head', 'wp_generator');                // #1
  remove_action('wp_head', 'wlwmanifest_link');            // #2
  remove_action('wp_head', 'rsd_link');                    // #3
  remove_action('wp_head', 'wp_shortlink_wp_head');        // #4
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);    // #5
  add_filter('the_generator', '__return_false');            // #6
  // add_filter('show_admin_bar','__return_false');            // #7
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );  // #8
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

//Only show admin bar for admin
if ( ! current_user_can( 'manage_options' ) ) {
    show_admin_bar( false );
}

// This theme uses wp_nav_menu() in one location.
function register_defaults() {

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wpm3dia_bas3' ),
	) );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
    'widgets'
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wpm3dia_bas3_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

}


/*
* Add Editor Style for adequate styling in text editor.
*
* @link http://codex.wordpress.org/Function_Reference/add_editor_style
*/
    add_editor_style( '/assets/css/project-editor.css' );

/**
 * Enqueue scripts for front-end.
 *
 * @uses wp_enqueue_script() to load front end scripts.
 *
 * @since 0.1.0
 *
 * @param bool $debug Whether to enable loading uncompressed/debugging assets. Default false.
 * @return void
 */
function scripts( $debug = false ) {
	$min = ( $debug || defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	// wp_enqueue_script( 
 //    'modernizr-js', 
 //    WPMBASE__TEMPLATE_URL . "/assets/js/vendor/modernizr.js",
 //    array( 'jquery' ), 
 //    WPMBASE__VERSION,
 //    true 
 //  );
  wp_enqueue_script(
		'wpm3dia_bas3',
		WPMBASE__TEMPLATE_URL . "/assets/js/project{$min}.js",
		array('jquery'),
		WPMBASE__VERSION,
		true
	);
  wp_enqueue_script(
    'wpm3dia_bas3_selectivizr',
    WPMBASE__TEMPLATE_URL . "/assets/js/ie/selectivizr-min.js",
    array(),
    '1.0.2',
    false
  );
  wp_script_add_data( 'wpm3dia_bas3_selectivizr', 'conditional', 'lt IE 9' );
  
  wp_enqueue_script(
    'wpm3dia_bas3_html5shiv',
    WPMBASE__TEMPLATE_URL . "/assets/js/ie/html5shiv.min.js",
    array(),
    '3.7.3',
    false
  );
  wp_script_add_data( 'wpm3dia_bas3_html5shiv', 'conditional', 'lt IE 9' );

  wp_enqueue_script(
    'wpm3dia_bas3_respond',
    WPMBASE__TEMPLATE_URL . "/assets/js/ie/respond.min.js",
    array(),
    '1.1.0',
    false
  );
  wp_script_add_data( 'wpm3dia_bas3_respond', 'conditional', 'lt IE 9' );
}

/**
 * Enqueue styles for front-end.
 *
 * @uses wp_enqueue_style() to load front end styles.
 *
 * @since 0.1.0
 *
 * @param bool $debug Whether to enable loading uncompressed/debugging assets. Default false.
 * @return void
 */
function styles( $debug = false ) {
	$min = ( $debug || defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style(
		'wpm3dia_bas3',
		WPMBASE__URL . "/assets/css/project{$min}.css",
		array(),
		WPMBASE__VERSION
	);
  // Internet Explorer specific stylesheet.
  wp_enqueue_style( 'wpm3dia_bas3-ie', 
    WPMBASE__URL . "/assets/css/ie{$min}.css",
    array(),
    WPMBASE__VERSION 
  );
  wp_style_add_data( 'wpm3dia_bas3-ie', 'conditional', 'IE' );
}

/**
 * Add humans.txt to the <head> element.
 *
 * @uses apply_filters()
 *
 * @since 0.1.0
 *
 * @return void
 */
function header_meta() {
	$humans = '<link type="text/plain" rel="author" href="' . WPMBASE__TEMPLATE_URL . '/humans.txt" />';

	echo apply_filters( 'wpm3dia_bas3__humans', $humans );
}


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpm3dia_bas3_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wpm3dia_bas3' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

/**
 * Add Modify Default From Email Address.
 *
 * @uses add_filter()
 *
 * @since 0.1.0
 *
 * @return void
 */
/**add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');

  function new_mail_from($old) {
  return 'admin@yourdomain.com';
  }

  function new_mail_from_name($old) {
  return 'Your Blog Name';
  }
**/

