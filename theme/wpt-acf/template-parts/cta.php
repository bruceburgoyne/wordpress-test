<?php
/**
 * Call to action band. Uses the "cta" group field.
 *
 * Optional $args['post_id'] reads the field from another post (articles use
 * the one on the Posts page).
 *
 * @package wpt-acf
 */

$wpt_cta = wpt_field( 'cta', ! empty( $args['post_id'] ) ? (int) $args['post_id'] : false );

if ( empty( $wpt_cta['heading'] ) && empty( $wpt_cta['button']['url'] ) ) {
	return;
}
?>
<section class="cta">
	<div class="container cta__inner">
		<div>
			<?php if ( ! empty( $wpt_cta['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_cta['heading'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $wpt_cta['text'] ) ) : ?>
				<p><?php echo wpt_text( $wpt_cta['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
			<?php endif; ?>
		</div>
		<?php echo wpt_link( $wpt_cta['button'] ?? null, 'button button--light' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</div>
</section>
