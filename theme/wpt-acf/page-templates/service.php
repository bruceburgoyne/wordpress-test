<?php
/**
 * Template Name: Service
 *
 * An individual service. Make the page a child of Services (Page attributes >
 * Parent), so its address is /services/{slug}/ and it appears under
 * "Other services" on its sibling pages.
 *
 * @package wpt-acf
 */

get_header();

$wpt_parent = wp_get_post_parent_id( get_the_ID() );

get_template_part(
	'template-parts/page-header',
	null,
	$wpt_parent ? array(
		'kicker'     => get_the_title( $wpt_parent ),
		'kicker_url' => get_permalink( $wpt_parent ),
	) : array()
);

$wpt_image    = wpt_field( 'image' );
$wpt_overview = wpt_field( 'overview' );
$wpt_included = wpt_field( 'included' );
$wpt_faqs     = wpt_field( 'faqs' );

// Other services: published sibling pages that use this template.
$wpt_others = $wpt_parent ? get_pages(
	array(
		'parent'      => $wpt_parent,
		'exclude'     => array( get_the_ID() ),
		'meta_key'    => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
		'meta_value'  => 'page-templates/service.php', // phpcs:ignore WordPress.DB.SlowDBQuery
		'sort_column' => 'menu_order,post_title',
	)
) : array();
?>

<?php if ( ! empty( $wpt_image['ID'] ) ) : ?>
	<div class="page-image">
		<?php
		echo wp_get_attachment_image(
			$wpt_image['ID'],
			'full',
			false,
			array(
				'class'         => 'page-image__img',
				'sizes'         => '(min-width: 80rem) 76rem, 100vw',
				'fetchpriority' => 'high',
				'loading'       => 'eager',
			)
		);
		?>
	</div>
<?php endif; ?>

<?php if ( ! empty( $wpt_overview['text'] ) ) : ?>
	<section class="section">
		<div class="container split split--single">
			<div>
				<?php if ( ! empty( $wpt_overview['heading'] ) ) : ?>
					<h2><?php echo esc_html( $wpt_overview['heading'] ); ?></h2>
				<?php endif; ?>
				<div class="prose"><?php echo wp_kses_post( $wpt_overview['text'] ); ?></div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $wpt_included['items'] ) ) : ?>
	<section class="section section--alt">
		<div class="container">
			<?php if ( ! empty( $wpt_included['heading'] ) ) : ?>
				<h2><?php echo esc_html( $wpt_included['heading'] ); ?></h2>
			<?php endif; ?>
			<div class="card-grid">
				<?php foreach ( $wpt_included['items'] as $wpt_item ) : ?>
					<article class="card">
						<h3><?php echo esc_html( $wpt_item['title'] ); ?></h3>
						<p><?php echo wpt_text( $wpt_item['text'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $wpt_faqs['items'] ) ) : ?>
	<section class="section">
		<div class="container split split--single">
			<div>
				<?php if ( ! empty( $wpt_faqs['heading'] ) ) : ?>
					<h2><?php echo esc_html( $wpt_faqs['heading'] ); ?></h2>
				<?php endif; ?>
				<div class="faq-list">
					<?php foreach ( $wpt_faqs['items'] as $wpt_faq ) : ?>
						<details class="faq">
							<summary><?php echo esc_html( $wpt_faq['question'] ); ?></summary>
							<p><?php echo wpt_text( $wpt_faq['answer'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
						</details>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( $wpt_others ) : ?>
	<section class="section section--alt">
		<div class="container">
			<h2><?php esc_html_e( 'Other services', 'wpt-acf' ); ?></h2>
			<div class="card-grid">
				<?php foreach ( $wpt_others as $wpt_other ) : ?>
					<?php $wpt_other_header = wpt_field( 'page_header', $wpt_other->ID ); ?>
					<article class="card">
						<h3><a class="card__link" href="<?php echo esc_url( get_permalink( $wpt_other ) ); ?>"><?php echo esc_html( get_the_title( $wpt_other ) ); ?></a></h3>
						<?php if ( ! empty( $wpt_other_header['intro'] ) ) : ?>
							<p><?php echo wpt_text( $wpt_other_header['intro'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/cta' );
get_footer();
