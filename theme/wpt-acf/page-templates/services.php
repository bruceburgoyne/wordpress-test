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
					<?php
					// Link to the service's own page, if one is chosen and published.
					$wpt_url = ( ! empty( $wpt_item['page'] ) && 'publish' === get_post_status( $wpt_item['page'] ) ) ? get_permalink( $wpt_item['page'] ) : '';
					?>
					<article class="service<?php echo empty( $wpt_item['image'] ) ? '' : ' service--image'; ?>">
						<?php
						if ( $wpt_url && ! empty( $wpt_item['image'] ) ) {
							printf(
								'<a class="service__media" href="%s" tabindex="-1" aria-hidden="true">%s</a>',
								esc_url( $wpt_url ),
								wpt_image( $wpt_item['image'], 'medium_large', 'service__image' ) // phpcs:ignore WordPress.Security.EscapeOutput
							);
						} else {
							echo wpt_image( $wpt_item['image'] ?? null, 'medium_large', 'service__image' ); // phpcs:ignore WordPress.Security.EscapeOutput
						}
						?>
						<div>
							<h3>
								<?php if ( $wpt_url ) : ?>
									<a class="service__link" href="<?php echo esc_url( $wpt_url ); ?>"><?php echo esc_html( $wpt_item['title'] ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $wpt_item['title'] ); ?>
								<?php endif; ?>
							</h3>
							<?php if ( ! empty( $wpt_item['summary'] ) ) : ?>
								<p class="lead"><?php echo wpt_text( $wpt_item['summary'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
							<?php endif; ?>
							<div class="prose"><?php echo wp_kses_post( $wpt_item['details'] ?? '' ); ?></div>
							<?php if ( $wpt_url ) : ?>
								<p class="service__more">
									<a class="text-link" href="<?php echo esc_url( $wpt_url ); ?>"><?php esc_html_e( 'Find out more', 'wpt-acf' ); ?><span class="screen-reader-text"> <?php /* translators: %s: service name */ echo esc_html( sprintf( __( 'about %s', 'wpt-acf' ), $wpt_item['title'] ) ); ?></span></a>
								</p>
							<?php endif; ?>
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
