<?php
/**
 * Blog helpers: standfirst, reading time, topics and archive titles.
 *
 * @package wpt-acf
 */

defined( 'ABSPATH' ) || exit;

/**
 * The page set as the "Posts page" in Settings > Reading, or 0.
 * Its ACF fields hold the blog header and the call to action under articles.
 *
 * @return int
 */
function wpt_blog_page_id() {
	return (int) get_option( 'page_for_posts' );
}

/**
 * Article standfirst (ACF), used as the summary on cards and in the header.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function wpt_standfirst( $post = null ) {
	$post = get_post( $post );
	return $post ? (string) wpt_field( 'standfirst', $post->ID ) : '';
}

/**
 * Estimated reading time in minutes, at 200 words a minute.
 *
 * @param int|WP_Post|null $post Post.
 * @return int
 */
function wpt_reading_time( $post = null ) {
	$words = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post ) ) );
	return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * The article's main topic: its first category, ignoring the default one.
 *
 * @param int|WP_Post|null $post Post.
 * @return WP_Term|null
 */
function wpt_topic( $post = null ) {
	$default = (int) get_option( 'default_category' );
	foreach ( get_the_category( get_post( $post )->ID ) as $term ) {
		if ( $term->term_id !== $default ) {
			return $term;
		}
	}
	return null;
}

// The standfirst stands in for the excerpt (feeds, search results, SEO plugins).
add_filter(
	'get_the_excerpt',
	function ( $excerpt, $post ) {
		$standfirst = wpt_standfirst( $post );
		return '' !== $standfirst ? $standfirst : $excerpt;
	},
	10,
	2
);

// Archive titles without "Category:" in front; templates add their own label.
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
