<?php
/**
 * A service tile linking to a service page: optional image, number, title,
 * the page's introduction and "Find out more". The whole tile is clickable.
 *
 * $args:
 * - page:   WP_Post for the service page.
 * - number: position shown as 01, 02, 03 (optional).
 *
 * @package wpt-acf
 */

$wpt_page = $args['page'] ?? null;
if ( ! $wpt_page ) {
	return;
}
$wpt_header = wpt_field( 'page_header', $wpt_page->ID );
$wpt_image  = wpt_field( 'image', $wpt_page->ID );
$wpt_title  = ! empty( $wpt_header['heading'] ) ? $wpt_header['heading'] : get_the_title( $wpt_page );
?>
<article class="service-tile">
	<?php if ( ! empty( $wpt_image['ID'] ) ) : ?>
		<?php echo wp_get_attachment_image( $wpt_image['ID'], 'medium_large', false, array( 'class' => 'service-tile__image', 'alt' => '' ) ); ?>
	<?php else : ?>
		<?php // Keeps tiles in line when other services have an image. Hidden by CSS when none do. ?>
		<div class="service-tile__placeholder" aria-hidden="true"><?php echo esc_html( mb_substr( $wpt_title, 0, 1 ) ); ?></div>
	<?php endif; ?>
	<div class="service-tile__body">
		<?php if ( ! empty( $args['number'] ) ) : ?>
			<p class="service-tile__number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $args['number'] ) ); ?></p>
		<?php endif; ?>
		<h3 class="service-tile__title"><a class="service-tile__link" href="<?php echo esc_url( get_permalink( $wpt_page ) ); ?>"><?php echo esc_html( $wpt_title ); ?></a></h3>
		<?php if ( ! empty( $wpt_header['intro'] ) ) : ?>
			<p class="service-tile__text"><?php echo wpt_text( $wpt_header['intro'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
		<?php endif; ?>
		<span class="service-tile__more" aria-hidden="true"><?php esc_html_e( 'Find out more', 'wpt-acf' ); ?></span>
	</div>
</article>
