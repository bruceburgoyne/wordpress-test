<?php
/**
 * Page header band. Uses the "page_header" group field, falling back to the page title.
 *
 * Optional $args:
 * - post_id: read the fields from this post instead of the current one
 *            (the blog archive passes the Posts page).
 * - kicker:  small label above the heading.
 *
 * @package wpt-acf
 */

$wpt_post_id = ! empty( $args['post_id'] ) ? (int) $args['post_id'] : false;
$wpt_header  = wpt_field( 'page_header', $wpt_post_id );
$wpt_heading = ! empty( $wpt_header['heading'] ) ? $wpt_header['heading'] : get_the_title( $wpt_post_id ? $wpt_post_id : null );
?>
<section class="page-header">
	<div class="container">
		<div>
			<?php if ( ! empty( $args['kicker'] ) ) : ?>
				<p class="kicker"><?php echo esc_html( $args['kicker'] ); ?></p>
			<?php endif; ?>
			<h1><?php echo esc_html( $wpt_heading ); ?></h1>
		</div>
		<?php if ( ! empty( $wpt_header['intro'] ) ) : ?>
			<p class="lead"><?php echo wpt_text( $wpt_header['intro'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
		<?php endif; ?>
	</div>
</section>
