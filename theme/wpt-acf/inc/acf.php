<?php
/**
 * ACF Pro integration: local JSON field groups and the Site Settings page.
 *
 * Field groups are stored as JSON in the theme's acf-json folder and kept in
 * Git. ACF loads them from there, and any edits made in WP Admin are written
 * back to the same folder so they can be committed.
 *
 * @package wpt-acf
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'acf/settings/save_json',
	function () {
		return get_template_directory() . '/acf-json';
	}
);

add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = get_template_directory() . '/acf-json';
		return $paths;
	}
);

// Global settings (logo, contact details, social links, footer).
add_action(
	'acf/init',
	function () {
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				array(
					'page_title' => __( 'Site Settings', 'wpt-acf' ),
					'menu_title' => __( 'Site Settings', 'wpt-acf' ),
					'menu_slug'  => 'site-settings',
					'capability' => 'edit_theme_options',
					'icon_url'   => 'dashicons-admin-generic',
					'position'   => 59,
					'redirect'   => false,
				)
			);
		}
	}
);

// Warn in WP Admin if ACF Pro is missing, since the theme depends on it.
add_action(
	'admin_notices',
	function () {
		if ( function_exists( 'acf_add_options_page' ) ) {
			return;
		}
		echo '<div class="notice notice-error"><p>';
		esc_html_e( 'The WPT ACF theme needs Advanced Custom Fields Pro. Please install and activate it.', 'wpt-acf' );
		echo '</p></div>';
	}
);
