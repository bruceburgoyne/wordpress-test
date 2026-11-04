<?php
/**
 * Template helpers. Each one fails quietly if ACF is not active or a field is empty.
 *
 * @package wpt-acf
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get an ACF field value, or null when ACF is not available.
 *
 * @param string     $name    Field name.
 * @param int|string $post_id Post ID, 'option', or false for the current post.
 * @return mixed
 */
function wpt_field( $name, $post_id = false ) {
	return function_exists( 'get_field' ) ? get_field( $name, $post_id ) : null;
}

/**
 * Get a value from the Site Settings options page.
 *
 * @param string $name Field name.
 * @return mixed
 */
function wpt_option( $name ) {
	return wpt_field( $name, 'option' );
}

/**
 * Render an ACF link field (return format: array).
 *
 * @param array|null $link  Link array with url, title and target.
 * @param string     $class CSS class.
 * @return string
 */
function wpt_link( $link, $class = 'button' ) {
	if ( empty( $link['url'] ) ) {
		return '';
	}
	$target = ! empty( $link['target'] ) ? $link['target'] : '_self';
	$rel    = '_blank' === $target ? ' rel="noopener"' : '';
	$title  = ! empty( $link['title'] ) ? $link['title'] : $link['url'];

	return sprintf(
		'<a class="%s" href="%s" target="%s"%s>%s</a>',
		esc_attr( $class ),
		esc_url( $link['url'] ),
		esc_attr( $target ),
		$rel,
		esc_html( $title )
	);
}

/**
 * Render an ACF image field (return format: array).
 *
 * @param array|null $image Image array.
 * @param string     $size  Registered image size.
 * @param string     $class CSS class.
 * @return string
 */
function wpt_image( $image, $size = 'large', $class = '' ) {
	if ( empty( $image['ID'] ) ) {
		return '';
	}
	return wp_get_attachment_image( $image['ID'], $size, false, array( 'class' => $class ) );
}

/**
 * Plain text with line breaks preserved.
 *
 * @param string|null $text Text from a textarea field.
 * @return string
 */
function wpt_text( $text ) {
	return $text ? nl2br( esc_html( $text ) ) : '';
}
