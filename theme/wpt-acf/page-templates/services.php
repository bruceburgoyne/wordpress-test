<?php
/**
 * Template Name: Services
 *
 * @package wpt-acf
 */

get_header();
get_template_part( 'template-parts/page-header' );

$wpt_services = wpt_field( 'services' );
$wpt_process  = wpt_field( 'process' );
?>

<?php if ( ! empty( $wpt_services['items'] ) ) : ?>
	<section class="section">
		<div class="container">
			<?php if ( ! empty( $wpt_services['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_services['heading'] ); ?></h2>
			<?php endif; ?>
			<div class="service-list">
				<?php foreach ( $wpt_services['items'] as $wpt_item ) : ?>
					<article class="service<?php echo empty( $wpt_item['image'] ) ? '' : ' service--image'; ?>">
						<?php echo wpt_image( $wpt_item['image'] ?? null, 'medium_large', 'service__image' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<div>
							<h3><?php echo esc_html( $wpt_item['title'] ); ?></h3>
							<?php if ( ! empty( $wpt_item['summary'] ) ) : ?>
								<p class="lead"><?php echo wpt_text( $wpt_item['summary'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
							<?php endif; ?>
							<div class="prose"><?php echo wp_kses_post( $wpt_item['details'] ?? '' ); ?></div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $wpt_process['steps'] ) ) : ?>
	<section class="section section--alt">
		<div class="container">
			<?php if ( ! empty( $wpt_process['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_process['heading'] ); ?></h2>
			<?php endif; ?>
			<ol class="steps">
				<?php foreach ( $wpt_process['steps'] as $wpt_step ) : ?>
					<li class="steps__item">
						<h3><?php echo esc_html( $wpt_step['title'] ); ?></h3>
						<p><?php echo wpt_text( $wpt_step['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
