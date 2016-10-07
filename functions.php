<?php
/**
 * wpm3dia_bas3 functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpm3dia_bas3
 */

// Useful global constants
define( 'WPMBASE__VERSION',      '0.1.0' );
define( 'WPMBASE__URL',          get_stylesheet_directory_uri() );
define( 'WPMBASE__TEMPLATE_URL', get_template_directory_uri() );
define( 'WPMBASE__PATH',         get_template_directory() . '/' );
define( 'WPMBASE__INC',          WPMBASE__PATH . 'inc/' );

// Include compartmentalized functions
require_once WPMBASE__INC . 'functions/core.php';

// Include lib classes

/**
 * Custom template tags for this theme.
 */
require WPMBASE__INC . 'template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require WPMBASE__INC . 'extras.php';

/**
 * Custom shortcodes.
 */
require WPMBASE__INC . 'shortcodes.php';

/**
 * Customizer additions.
 */
require WPMBASE__INC . 'customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require WPMBASE__INC . 'jetpack.php';

// Run the setup functions
WPM3dia\wpm3dia_bas3\Core\setup();

