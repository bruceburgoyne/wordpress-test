<?php
/**
 * WPT ACF theme bootstrap.
 *
 * @package wpt-acf
 */

defined( 'ABSPATH' ) || exit;

define( 'WPT_VERSION', '0.1.0' );

require_once get_template_directory() . '/inc/editor.php';
require_once get_template_directory() . '/inc/acf.php';
require_once get_template_directory() . '/inc/helpers.php';

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

		register_nav_menus(
			array(
				'primary' => __( 'Primary navigation', 'wpt-acf' ),
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'wpt-main',
			get_template_directory_uri() . '/assets/css/main.css',
			array(),
			WPT_VERSION
		);
	}
);
