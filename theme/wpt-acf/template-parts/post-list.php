<?php
/**
 * The list of articles for the blog page and the topic, tag and date archives:
 * a topic filter, an optional lead story, a grid of cards and page numbers.
 *
 * Optional $args:
 * - lead: show the first article as a large lead story.
 *
 * @package wpt-acf
 */

$wpt_lead    = ! empty( $args['lead'] );
$wpt_blog_id = wpt_blog_page_id();
$wpt_topics  = get_categories(
	array(
		'exclude'    => array( (int) get_option( 'default_category' ) ),
		'hide_empty' => true,
	)
);
?>
<div class="post-list container">
	<?php if ( count( $wpt_topics ) > 1 ) : ?>
		<nav class="topic-nav" aria-label="<?php esc_attr_e( 'Topics', 'wpt-acf' ); ?>">
			<ul>
				<li>
					<a href="<?php echo esc_url( $wpt_blog_id ? get_permalink( $wpt_blog_id ) : home_url( '/' ) ); ?>"<?php echo is_home() ? ' aria-current="page"' : ''; ?>><?php esc_html_e( 'All articles', 'wpt-acf' ); ?></a>
				</li>
				<?php foreach ( $wpt_topics as $wpt_term ) : ?>
					<li>
						<a href="<?php echo esc_url( get_category_link( $wpt_term ) ); ?>"<?php echo is_category( $wpt_term->term_id ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $wpt_term->name ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<?php
		if ( $wpt_lead ) {
			the_post();
			get_template_part( 'template-parts/post-card', null, array( 'lead' => true ) );
		}
		?>

		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/post-card' );
				}
				?>
			</div>
		<?php endif; ?>

		<?php
		the_posts_pagination(
			array(
				'mid_size'           => 1,
				'prev_text'          => __( 'Newer', 'wpt-acf' ),
				'next_text'          => __( 'Older', 'wpt-acf' ),
				'screen_reader_text' => __( 'More articles', 'wpt-acf' ),
			)
		);
		?>
	<?php else : ?>
		<p class="post-list__empty"><?php esc_html_e( 'There are no articles here yet.', 'wpt-acf' ); ?></p>
	<?php endif; ?>
</div>
