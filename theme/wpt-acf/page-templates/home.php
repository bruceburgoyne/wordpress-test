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

<section class="hero<?php echo ! empty( $wpt_hero['image'] ) ? ' hero--image' : ''; ?>">
	<?php echo wpt_image( $wpt_hero['image'] ?? null, 'full', 'hero__bg' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	<div class="container hero__content">
		<h1><?php echo esc_html( ! empty( $wpt_hero['heading'] ) ? $wpt_hero['heading'] : get_bloginfo( 'name' ) ); ?></h1>
		<?php if ( ! empty( $wpt_hero['text'] ) ) : ?>
			<p class="lead"><?php echo wpt_text( $wpt_hero['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
		<?php endif; ?>
		<div class="button-row">
			<?php echo wpt_link( $wpt_hero['primary_button'] ?? null ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			<?php echo wpt_link( $wpt_hero['secondary_button'] ?? null, 'button button--ghost' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</div>
</section>

<?php
// Marquee strip built from the highlight titles. Decorative only, so hidden from screen readers.
$wpt_marquee = ! empty( $wpt_highlights['items'] ) ? array_filter( wp_list_pluck( $wpt_highlights['items'], 'title' ) ) : array();
if ( $wpt_marquee ) :
	?>
	<div class="marquee" aria-hidden="true">
		<?php for ( $wpt_i = 0; $wpt_i < 2; $wpt_i++ ) : ?>
			<div class="marquee__track">
				<?php foreach ( array_merge( $wpt_marquee, $wpt_marquee ) as $wpt_word ) : ?>
					<span><?php echo esc_html( $wpt_word ); ?></span>
				<?php endforeach; ?>
			</div>
		<?php endfor; ?>
	</div>
<?php endif; ?>

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
