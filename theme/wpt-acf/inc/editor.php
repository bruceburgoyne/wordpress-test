<?php
/**
 * Editing experience: ACF for pages, a curated block editor for posts.
 *
 * - Pages have no content editor at all. ACF fields are the only CMS controls.
 * - Posts (blog articles) use the block editor (Gutenberg), but only for
 *   writing: a short list of content blocks, no colour, font size or spacing
 *   controls, and headings limited to H2 to H4. Design stays in the theme.
 *   theme.json switches the design controls off; this file does the rest.
 * - Block styles load on single articles only, so the ACF pages are unchanged.
 *
 * @package wpt-acf
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types that use the block editor. Everything else gets ACF only.
 */
const WPT_BLOCK_EDITOR_POST_TYPES = array( 'post' );

add_filter(
	'use_block_editor_for_post_type',
	function ( $use, $post_type ) {
		return in_array( $post_type, WPT_BLOCK_EDITOR_POST_TYPES, true );
	},
	100,
	2
);
add_filter( 'use_widgets_block_editor', '__return_false' );

add_action(
	'init',
	function () {
		// Pages: ACF fields only.
		remove_post_type_support( 'page', 'editor' );

		// Posts: the ACF "Standfirst" replaces the excerpt, and there are no comments.
		remove_post_type_support( 'post', 'excerpt' );
		remove_post_type_support( 'post', 'comments' );
		remove_post_type_support( 'post', 'trackbacks' );
	},
	100
);

add_action(
	'after_setup_theme',
	function () {
		remove_theme_support( 'core-block-patterns' );

		// Make the editor look like the article on the site.
		add_theme_support( 'editor-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_editor_style(
			array(
				wpt_fonts_url(),
				'assets/css/tokens.css',
				'assets/css/editor.css',
				'assets/css/article.css',
			)
		);
	}
);

/**
 * The blocks writers can use in an article.
 */
function wpt_allowed_blocks() {
	return array(
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/list-item',
		'core/quote',
		'core/pullquote',
		'core/image',
		'core/gallery',
		'core/embed',
		'core/video',
		'core/table',
		'core/separator',
		'core/buttons',
		'core/button',
		'core/footnotes',
	);
}

add_filter(
	'allowed_block_types_all',
	function ( $allowed, $context ) {
		if ( ! empty( $context->post ) && in_array( $context->post->post_type, WPT_BLOCK_EDITOR_POST_TYPES, true ) ) {
			return wpt_allowed_blocks();
		}
		return $allowed;
	},
	10,
	2
);

// The article title is the only H1, so headings in the body start at H2.
add_filter(
	'register_block_type_args',
	function ( $args, $block_type ) {
		if ( 'core/heading' === $block_type && isset( $args['attributes'] ) ) {
			$args['attributes']['levelOptions']['default'] = array( 2, 3, 4 );
		}
		return $args;
	},
	10,
	2
);

// No remote patterns, block directory or Openverse: a quieter, self-contained editor.
add_filter( 'should_load_remote_block_patterns', '__return_false' );
remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
add_filter(
	'block_editor_settings_all',
	function ( $settings ) {
		$settings['enableOpenverseMediaCategory'] = false;
		return $settings;
	}
);

/**
 * Whether the current front-end view shows block content.
 */
function wpt_is_block_view() {
	return is_singular( WPT_BLOCK_EDITOR_POST_TYPES );
}

// Elsewhere (all the ACF pages and the archives), load no block CSS at all.
add_action(
	'wp',
	function () {
		if ( wpt_is_block_view() ) {
			return;
		}
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
		remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		if ( wpt_is_block_view() ) {
			wp_dequeue_style( 'classic-theme-styles' );
			return;
		}
		foreach ( array( 'wp-block-library', 'wp-block-library-theme', 'global-styles', 'classic-theme-styles' ) as $handle ) {
			wp_dequeue_style( $handle );
		}
	},
	100
);
