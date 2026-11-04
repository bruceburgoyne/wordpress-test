<?php
/**
 * Switch off the block editor (Gutenberg) and the page content editor.
 *
 * Pages are built entirely from ACF fields, so the main content box is removed
 * from pages. Posts fall back to the classic editor rather than blocks.
 *
 * @package wpt-acf
 */

defined( 'ABSPATH' ) || exit;

// No block editor for any post type, and no block-based widgets screen.
add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
add_filter( 'use_widgets_block_editor', '__return_false' );

// Pages get no content editor at all: ACF fields are the only CMS controls.
add_action(
	'init',
	function () {
		remove_post_type_support( 'page', 'editor' );
	},
	100
);

// No block patterns or block styles on the front end.
add_action(
	'after_setup_theme',
	function () {
		remove_theme_support( 'core-block-patterns' );
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		foreach ( array( 'wp-block-library', 'wp-block-library-theme', 'global-styles', 'classic-theme-styles' ) as $handle ) {
			wp_dequeue_style( $handle );
		}
	},
	100
);

remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
