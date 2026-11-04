<?php
/**
 * Template Name: About
 *
 * @package wpt-acf
 */

get_header();
get_template_part( 'template-parts/page-header' );

$wpt_story  = wpt_field( 'story' );
$wpt_values = wpt_field( 'values' );
$wpt_team   = wpt_field( 'team' );
?>

<?php if ( ! empty( $wpt_story['text'] ) ) : ?>
	<section class="section">
		<div class="container split<?php echo empty( $wpt_story['image'] ) ? ' split--single' : ''; ?>">
			<div>
				<?php if ( ! empty( $wpt_story['heading'] ) ) : ?>
					<h2><?php echo esc_html( $wpt_story['heading'] ); ?></h2>
				<?php endif; ?>
				<div class="prose"><?php echo wp_kses_post( $wpt_story['text'] ); ?></div>
			</div>
			<?php echo wpt_image( $wpt_story['image'] ?? null, 'large', 'split__image' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $wpt_values['items'] ) ) : ?>
	<section class="section section--alt">
		<div class="container">
			<?php if ( ! empty( $wpt_values['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_values['heading'] ); ?></h2>
			<?php endif; ?>
			<div class="card-grid">
				<?php foreach ( $wpt_values['items'] as $wpt_item ) : ?>
					<article class="card">
						<h3><?php echo esc_html( $wpt_item['title'] ); ?></h3>
						<p><?php echo wpt_text( $wpt_item['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $wpt_team['members'] ) ) : ?>
	<section class="section">
		<div class="container">
			<?php if ( ! empty( $wpt_team['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_team['heading'] ); ?></h2>
			<?php endif; ?>
			<div class="card-grid">
				<?php foreach ( $wpt_team['members'] as $wpt_member ) : ?>
					<article class="person">
						<?php echo wpt_image( $wpt_member['photo'] ?? null, 'medium', 'person__photo' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<h3><?php echo esc_html( $wpt_member['name'] ); ?></h3>
						<?php if ( ! empty( $wpt_member['role'] ) ) : ?>
							<p class="person__role"><?php echo esc_html( $wpt_member['role'] ); ?></p>
						<?php endif; ?>
						<p><?php echo wpt_text( $wpt_member['bio'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
