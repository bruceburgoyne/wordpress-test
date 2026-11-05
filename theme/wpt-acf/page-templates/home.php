<?php
/**
 * Template Name: Home
 *
 * @package wpt-acf
 */

get_header();

$wpt_hero       = wpt_field( 'hero' );
$wpt_intro      = wpt_field( 'intro' );
$wpt_highlights = wpt_field( 'highlights' );
?>

<section class="hero<?php echo ! empty( $wpt_hero['image'] ) ? ' hero--split' : ''; ?>">
	<div class="hero__content">
		<?php if ( ! empty( $wpt_hero['kicker'] ) ) : ?>
			<p class="kicker"><?php echo esc_html( $wpt_hero['kicker'] ); ?></p>
		<?php endif; ?>
		<h1>
			<?php echo esc_html( ! empty( $wpt_hero['heading'] ) ? $wpt_hero['heading'] : get_bloginfo( 'name' ) ); ?>
			<?php if ( ! empty( $wpt_hero['heading_emphasis'] ) ) : ?>
				<em><?php echo esc_html( $wpt_hero['heading_emphasis'] ); ?></em>
			<?php endif; ?>
		</h1>
		<?php if ( ! empty( $wpt_hero['text'] ) ) : ?>
			<p class="hero__text"><?php echo wpt_text( $wpt_hero['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
		<?php endif; ?>
		<div class="button-row">
			<?php echo wpt_link( $wpt_hero['primary_button'] ?? null, 'button button--arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php echo wpt_link( $wpt_hero['secondary_button'] ?? null, 'text-link' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
	<?php if ( ! empty( $wpt_hero['image'] ) ) : ?>
		<div class="hero__media">
			<?php
			echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput
				$wpt_hero['image']['ID'],
				'full',
				false,
				array(
					'class'         => 'hero__image',
					'sizes'         => '(min-width: 56rem) 50vw, 100vw',
					'fetchpriority' => 'high',
					'loading'       => 'eager',
				)
			);
			?>
		</div>
	<?php endif; ?>
</section>

<?php if ( ! empty( $wpt_intro['heading'] ) || ! empty( $wpt_intro['text'] ) ) : ?>
	<section class="section">
		<div class="container container--narrow">
			<?php if ( ! empty( $wpt_intro['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_intro['heading'] ); ?></h2>
			<?php endif; ?>
			<div class="prose"><?php echo wp_kses_post( $wpt_intro['text'] ?? '' ); ?></div>
		</div>
	</section>
<?php endif; ?>

<?php
// Services: tiles linking to each service page.
// Until the Services tab is saved in WP Admin, show every service under "Our services".
$wpt_services = wpt_field( 'services' );
if ( ! is_array( $wpt_services ) ) {
	$wpt_services = array( 'heading' => __( 'Our services', 'wpt-acf' ) );
}
$wpt_tiles = ( ! isset( $wpt_services['show'] ) || $wpt_services['show'] ) ? wpt_service_pages( $wpt_services['pages'] ?? array() ) : array();
$wpt_svc_page = get_page_by_path( 'services' );
if ( $wpt_tiles ) :
	?>
	<section class="section">
		<div class="container">
			<div class="section-header">
				<div>
					<?php if ( ! empty( $wpt_services['heading'] ) ) : ?>
						<h2><?php echo esc_html( $wpt_services['heading'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $wpt_services['intro'] ) ) : ?>
						<p class="section-header__text"><?php echo wpt_text( $wpt_services['intro'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
					<?php endif; ?>
				</div>
				<?php if ( $wpt_svc_page && 'publish' === $wpt_svc_page->post_status ) : ?>
					<a class="text-link" href="<?php echo esc_url( get_permalink( $wpt_svc_page ) ); ?>"><?php esc_html_e( 'All services', 'wpt-acf' ); ?></a>
				<?php endif; ?>
			</div>
			<div class="service-tiles">
				<?php
				foreach ( $wpt_tiles as $wpt_i => $wpt_tile ) {
					get_template_part(
						'template-parts/service-tile',
						null,
						array(
							'page'   => $wpt_tile,
							'number' => $wpt_i + 1,
						)
					);
				}
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $wpt_highlights['items'] ) ) : ?>
	<section class="section section--alt">
		<div class="container">
			<?php if ( ! empty( $wpt_highlights['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_highlights['heading'] ); ?></h2>
			<?php endif; ?>
			<div class="card-grid">
				<?php foreach ( $wpt_highlights['items'] as $wpt_item ) : ?>
					<article class="card">
						<h3><?php echo esc_html( $wpt_item['title'] ); ?></h3>
						<p><?php echo wpt_text( $wpt_item['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
						<?php echo wpt_link( $wpt_item['link'] ?? null, 'text-link' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
