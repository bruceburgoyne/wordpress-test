<?php
/**
 * Template Name: Contact
 *
 * @package wpt-acf
 */

get_header();
get_template_part( 'template-parts/page-header' );

$wpt_details = wpt_field( 'details' );
$wpt_hours   = wpt_field( 'hours' );
$wpt_form    = wpt_field( 'form' );
$wpt_map     = wpt_field( 'map' );

$wpt_show_global = ! isset( $wpt_details['show_global_details'] ) || $wpt_details['show_global_details'];
$wpt_phone       = wpt_option( 'phone' );
$wpt_email       = wpt_option( 'email' );
$wpt_address     = wpt_option( 'address' );

$wpt_iframe_tags = array(
	'iframe' => array(
		'src'             => true,
		'width'           => true,
		'height'          => true,
		'style'           => true,
		'loading'         => true,
		'allowfullscreen' => true,
		'referrerpolicy'  => true,
		'title'           => true,
	),
);
?>

<section class="section">
	<div class="container split">
		<div>
			<?php if ( ! empty( $wpt_details['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_details['heading'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $wpt_details['text'] ) ) : ?>
				<p><?php echo wpt_text( $wpt_details['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
			<?php endif; ?>

			<?php if ( $wpt_show_global ) : ?>
				<dl class="contact-list">
					<?php if ( $wpt_phone ) : ?>
						<dt><?php esc_html_e( 'Phone', 'wpt-acf' ); ?></dt>
						<dd><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $wpt_phone ) ); ?>"><?php echo esc_html( $wpt_phone ); ?></a></dd>
					<?php endif; ?>
					<?php if ( $wpt_email ) : ?>
						<dt><?php esc_html_e( 'Email', 'wpt-acf' ); ?></dt>
						<dd><a href="mailto:<?php echo esc_attr( antispambot( $wpt_email ) ); ?>"><?php echo esc_html( antispambot( $wpt_email ) ); ?></a></dd>
					<?php endif; ?>
					<?php if ( $wpt_address ) : ?>
						<dt><?php esc_html_e( 'Address', 'wpt-acf' ); ?></dt>
						<dd><address><?php echo wpt_text( $wpt_address ); // phpcs:ignore WordPress.Security.EscapeOutput ?></address></dd>
					<?php endif; ?>
				</dl>
			<?php endif; ?>

			<?php if ( ! empty( $wpt_hours['rows'] ) ) : ?>
				<?php if ( ! empty( $wpt_hours['heading'] ) ) : ?>
					<h3><?php echo esc_html( $wpt_hours['heading'] ); ?></h3>
				<?php endif; ?>
				<table class="hours">
					<?php foreach ( $wpt_hours['rows'] as $wpt_row ) : ?>
						<tr><th scope="row"><?php echo esc_html( $wpt_row['days'] ); ?></th><td><?php echo esc_html( $wpt_row['times'] ); ?></td></tr>
					<?php endforeach; ?>
				</table>
			<?php endif; ?>
		</div>

		<div>
			<?php // Without a form, the heading would sit over nothing, so only editors see it (with the notice). ?>
			<?php if ( ! empty( $wpt_form['heading'] ) && ( ! empty( $wpt_form['shortcode'] ) || current_user_can( 'edit_pages' ) ) ) : ?>
				<h2><?php echo esc_html( $wpt_form['heading'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $wpt_form['shortcode'] ) ) : ?>
				<div class="form-wrap"><?php echo do_shortcode( $wpt_form['shortcode'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			<?php elseif ( current_user_can( 'edit_pages' ) ) : ?>
				<p class="notice"><?php esc_html_e( 'Add a form shortcode in the Form tab to show an enquiry form here.', 'wpt-acf' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php if ( ! empty( $wpt_map['embed'] ) ) : ?>
	<section class="map"><?php echo wp_kses( $wpt_map['embed'], $wpt_iframe_tags ); ?></section>
<?php endif; ?>

<?php
get_footer();
