<?php
/**
 * "More articles" under a single article: up to three, from the same topic
 * first, topped up with the newest articles.
 *
 * Optional $args['topic']: the current article's topic (WP_Term).
 *
 * @package wpt-acf
 */

$wpt_current = get_the_ID();
$wpt_ids     = array();

if ( ! empty( $args['topic'] ) ) {
	$wpt_ids = get_posts(
		array(
			'fields'         => 'ids',
			'posts_per_page' => 3,
			'cat'            => $args['topic']->term_id,
			'post__not_in'   => array( $wpt_current ),
		)
	);
}
if ( count( $wpt_ids ) < 3 ) {
	$wpt_ids = array_merge(
		$wpt_ids,
		get_posts(
			array(
				'fields'         => 'ids',
				'posts_per_page' => 3 - count( $wpt_ids ),
				'post__not_in'   => array_merge( array( $wpt_current ), $wpt_ids ),
			)
		)
	);
}
if ( ! $wpt_ids ) {
	return;
}

$wpt_related = new WP_Query(
	array(
		'post__in'            => $wpt_ids,
		'orderby'             => 'post__in',
		'posts_per_page'      => count( $wpt_ids ),
		'ignore_sticky_posts' => true,
	)
);
$wpt_blog_id = wpt_blog_page_id();
?>
<section class="related" aria-labelledby="related-heading">
	<div class="container">
		<div class="related__header">
			<h2 id="related-heading"><?php esc_html_e( 'More articles', 'wpt-acf' ); ?></h2>
			<?php if ( $wpt_blog_id ) : ?>
				<a class="text-link" href="<?php echo esc_url( get_permalink( $wpt_blog_id ) ); ?>"><?php esc_html_e( 'All articles', 'wpt-acf' ); ?></a>
			<?php endif; ?>
		</div>
		<div class="post-grid">
			<?php
			while ( $wpt_related->have_posts() ) {
				$wpt_related->the_post();
				get_template_part( 'template-parts/post-card' );
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
