<?php
/**
 * Push pages and ACF content from the content/ folder into WordPress.
 *
 * Run with WP-CLI from the Local site shell:
 *   wp eval-file /path/to/wordpress-test/scripts/seed.php /path/to/wordpress-test/content
 *
 * Safe to run repeatedly: pages are matched by slug and updated in place.
 * Field values in the JSON overwrite whatever is in WordPress for those fields.
 *
 * In link URLs, "{{page:slug}}" is replaced with that page's permalink.
 *
 * @package wpt-acf
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit;
}

$wpt_content_dir = isset( $args[0] ) ? rtrim( $args[0], '/' ) : dirname( __DIR__ ) . '/content';

if ( ! function_exists( 'acf_add_options_page' ) ) {
	WP_CLI::error( 'ACF Pro is not active. Install and activate it, then run this again.' );
}
if ( ! is_dir( $wpt_content_dir . '/pages' ) ) {
	WP_CLI::error( "No pages folder found in {$wpt_content_dir}." );
}

/**
 * Read and decode a JSON file, stopping on errors.
 *
 * @param string $path File path.
 * @return array
 */
function wpt_seed_read_json( $path ) {
	$data = json_decode( file_get_contents( $path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( ! is_array( $data ) ) {
		WP_CLI::error( "Could not read {$path}: " . json_last_error_msg() );
	}
	return $data;
}

/**
 * Map top-level field names to field keys for the groups shown on a post or options page.
 *
 * Saving by key (not name) makes sure ACF stores its reference meta, which
 * repeaters and groups need to load correctly.
 *
 * @param array $filter Arguments for acf_get_field_groups().
 * @return array name => key
 */
function wpt_seed_field_map( $filter ) {
	$map = array();
	foreach ( acf_get_field_groups( $filter ) as $group ) {
		foreach ( acf_get_fields( $group ) as $field ) {
			if ( '' !== $field['name'] ) {
				$map[ $field['name'] ] = $field['key'];
			}
		}
	}
	return $map;
}

/**
 * Replace {{page:slug}} tokens with permalinks, recursively.
 *
 * @param mixed $value Field value.
 * @return mixed
 */
function wpt_seed_resolve_links( $value ) {
	if ( is_array( $value ) ) {
		return array_map( 'wpt_seed_resolve_links', $value );
	}
	if ( ! is_string( $value ) ) {
		return $value;
	}
	return preg_replace_callback(
		'/\{\{page:([a-z0-9\-\/]+)\}\}/',
		function ( $m ) {
			$page = get_page_by_path( $m[1] );
			if ( ! $page ) {
				WP_CLI::warning( "Link to unknown page '{$m[1]}' left as '#'." );
				return '#';
			}
			return get_permalink( $page );
		},
		$value
	);
}

/**
 * Save a set of field values, warning about any name with no matching field.
 *
 * @param array      $fields  name => value.
 * @param array      $map     name => key.
 * @param int|string $post_id Post ID or 'option'.
 * @param string     $label   Label for messages.
 */
function wpt_seed_save_fields( $fields, $map, $post_id, $label ) {
	foreach ( $fields as $name => $value ) {
		if ( ! isset( $map[ $name ] ) ) {
			WP_CLI::warning( "{$label}: no ACF field called '{$name}', skipped." );
			continue;
		}
		update_field( $map[ $name ], wpt_seed_resolve_links( $value ), $post_id );
	}
}

// 1. Create or update every page first, so {{page:slug}} links can resolve.
$wpt_pages = array();
foreach ( glob( $wpt_content_dir . '/pages/*.json' ) as $wpt_file ) {
	$wpt_def = wpt_seed_read_json( $wpt_file );
	$wpt_existing = get_page_by_path( $wpt_def['slug'] );

	$wpt_postarr = array(
		'post_type'   => 'page',
		'post_status' => 'publish',
		'post_title'  => $wpt_def['title'],
		'post_name'   => $wpt_def['slug'],
		'menu_order'  => isset( $wpt_def['menu_order'] ) ? (int) $wpt_def['menu_order'] : 0,
	);
	if ( $wpt_existing ) {
		$wpt_postarr['ID'] = $wpt_existing->ID;
		$wpt_id            = wp_update_post( $wpt_postarr, true );
	} else {
		$wpt_id = wp_insert_post( $wpt_postarr, true );
	}
	if ( is_wp_error( $wpt_id ) ) {
		WP_CLI::error( $wpt_id->get_error_message() );
	}
	update_post_meta( $wpt_id, '_wp_page_template', $wpt_def['template'] );

	$wpt_def['id'] = $wpt_id;
	$wpt_pages[]   = $wpt_def;
	WP_CLI::log( ( $wpt_existing ? 'Updated' : 'Created' ) . " page '{$wpt_def['title']}' (ID {$wpt_id})" );
}

usort(
	$wpt_pages,
	function ( $a, $b ) {
		return ( $a['menu_order'] ?? 0 ) <=> ( $b['menu_order'] ?? 0 );
	}
);

// 2. Fill each page's ACF fields.
foreach ( $wpt_pages as $wpt_def ) {
	$wpt_map = wpt_seed_field_map( array( 'post_id' => $wpt_def['id'] ) );
	if ( ! $wpt_map ) {
		WP_CLI::warning( "No ACF field groups found for '{$wpt_def['title']}'. Is the WPT ACF theme active?" );
		continue;
	}
	wpt_seed_save_fields( $wpt_def['fields'] ?? array(), $wpt_map, $wpt_def['id'], $wpt_def['title'] );

	if ( ! empty( $wpt_def['front_page'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $wpt_def['id'] );
		WP_CLI::log( "Set '{$wpt_def['title']}' as the front page" );
	}
}

// 3. Site Settings options page.
$wpt_settings_file = $wpt_content_dir . '/site-settings.json';
if ( file_exists( $wpt_settings_file ) ) {
	$wpt_map = wpt_seed_field_map( array( 'options_page' => 'site-settings' ) );
	wpt_seed_save_fields( wpt_seed_read_json( $wpt_settings_file ), $wpt_map, 'option', 'Site Settings' );
	WP_CLI::log( 'Updated Site Settings' );
}

// 4. Primary menu, rebuilt from the pages in menu order.
$wpt_menu = wp_get_nav_menu_object( 'Primary' );
$wpt_menu_id = $wpt_menu ? $wpt_menu->term_id : wp_create_nav_menu( 'Primary' );
foreach ( wp_get_nav_menu_items( $wpt_menu_id ) ?: array() as $wpt_item ) {
	wp_delete_post( $wpt_item->ID, true );
}
foreach ( $wpt_pages as $wpt_def ) {
	wp_update_nav_menu_item(
		$wpt_menu_id,
		0,
		array(
			'menu-item-object-id' => $wpt_def['id'],
			'menu-item-object'    => 'page',
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		)
	);
}
$wpt_locations            = get_theme_mod( 'nav_menu_locations', array() );
$wpt_locations['primary'] = $wpt_menu_id;
set_theme_mod( 'nav_menu_locations', $wpt_locations );
WP_CLI::log( 'Rebuilt the Primary menu' );

WP_CLI::success( count( $wpt_pages ) . ' pages pushed to WordPress.' );
