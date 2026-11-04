<?php
/**
 * Call to action band. Uses the "cta" group field.
 *
 * @package wpt-acf
 */

$wpt_cta = wpt_field( 'cta' );

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
