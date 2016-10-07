<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wpm3dia_bas3
 */

/**
 * Register and enqueue a custom stylesheet in the WordPress admin.
 */
function wpm3dia_bas3_adstyle() {
  wp_register_style( 'custom_wp_admin_css', WPMBASE__TEMPLATE_URL . '/assets/css/admin-style.css', false, '1.0.0' );
  wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'wpm3dia_bas3_adstyle' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wpm3dia_bas3_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'wpm3dia_bas3_body_classes' );

//Shortcode For using columns in the editor **NEEDS SERIOUS WORK**

function column_func( $atts, $content="" ) {
  $divclass = "cols";
  if ($atts['number'] != "") {
    $divclass = "cols-" . $atts['number'];
  }
  return "<div class='" . $divclass . "'>" . $content . "</div>";
}
add_shortcode( 'column', 'column_func' );

//Clean up Navigation
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
  return is_array($var) ? array_intersect($var, array('current-menu-item')) : '';
}

//Add post image to admin columns
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 1, 2);
 
function posts_columns($defaults){
    $defaults['wpm3dia_post_thumbs'] = __('Image');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
        if($column_name === 'wpm3dia_post_thumbs'){
        echo the_post_thumbnail( 'thumbnail' );
    }
}

//Redirect any Attachment Pages 

function wpm3dia_template_redirect () {
    global $wp_query, $post;

    if ( is_attachment() ) {
        $post_parent = $post->post_parent;

        if ( $post_parent ) {
            wp_redirect( get_permalink($post->post_parent), 301 );
            exit;
        }

        $wp_query->set_404();

        return;
    }

    if ( is_author() || is_date() ) {
        $wp_query->set_404();
    }
}
add_action( 'template_redirect', 'wpm3dia_template_redirect' );

//Responsive Video's
function wpm3dia_embed_oembed_html($html, $url, $attr, $post_id) {
      return '<figure class="video-wrapper">' . $html . '</figure>';
}
add_filter('embed_oembed_html', 'wpm3dia_embed_oembed_html', 9999, 4);

//Responsive Captioned Images
function wpm3dia_img_caption_shortcode ( $empty, $attr, $content ) {
    $attr = shortcode_atts( array(
        'id'      => '',
        'align'   => 'alignnone',
        'width'   => '',
        'caption' => '',
        'class'   => 'wp-caption'
    ), $attr, 'caption' );

    if ( 1 > (int)$attr['width'] || empty( $attr['caption'] ) ) {
        return $content;
    }

    if ( $attr['id'] ) {
        $attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '"';
    }

    $attr['class'] = 'class="' . esc_attr( trim( $attr['align'] . ' ' . $attr['class'] ) ) . '"';

    return '<figure ' . $attr['id'] . ' ' . $attr['class'] . '>'
        . do_shortcode( $content )
        . '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption>'
        . '</figure>';
}
add_filter( 'img_caption_shortcode', 'wpm3dia_img_caption_shortcode', 10, 3 );

/**
 * Modify Excerpt Length & more text.
 *
 * @uses add_filter()
 *
 * @since 0.1.0
 *
 * @return void
 */


  //----- Change Length
function modify_excerpt_length($length) {
    return 30;
}
 
add_filter('excerpt_length', 'modify_excerpt_length', 999);
 
//----- Change '[...]' Text
function modify_excerpt_more($more) {
    return '...';
}
 
add_filter('excerpt_more', 'modify_excerpt_more');
add_filter('xmlrpc_enabled', '__return_false');

// Move Yoast Meta Box to bottom
function yoasttobottom() {
  return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

// Allow Shortcode in widgets
if ( !is_admin() ){
    add_filter('widget_text', 'do_shortcode', 11);
}
