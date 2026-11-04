<?php
/**
 * Page header band. Uses the "page_header" group field, falling back to the page title.
 *
 * @package wpt-acf
 */

$wpt_header  = wpt_field( 'page_header' );
$wpt_heading = ! empty( $wpt_header['heading'] ) ? $wpt_header['heading'] : get_the_title();
?>
<section class="page-header">
	<div class="container">
		<h1><?php echo esc_html( $wpt_heading ); ?></h1>
		<?php if ( ! empty( $wpt_header['intro'] ) ) : ?>
			<p class="lead"><?php echo wpt_text( $wpt_header['intro'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
		<?php endif; ?>
	</div>
</section>
