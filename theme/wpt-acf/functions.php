<?php
/**
 * WPT ACF theme bootstrap.
 *
 * @package wpt-acf
 */

defined( 'ABSPATH' ) || exit;

define( 'WPT_VERSION', '0.2.0' );

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
		// Space Grotesk (headings) and Archivo (body). Before going live, consider
		// self-hosting these: loading from Google sends visitor IP addresses to Google.
		wp_enqueue_style(
			'wpt-fonts',
			'https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700&family=Space+Grotesk:wght@500;700&display=swap',
			array(),
			null
		);
		wp_enqueue_style(
			'wpt-main',
			get_template_directory_uri() . '/assets/css/main.css',
			array( 'wpt-fonts' ),
			WPT_VERSION
		);
		wp_enqueue_script(
			'wpt-motion',
			get_template_directory_uri() . '/assets/js/motion.js',
			array(),
			WPT_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
);
