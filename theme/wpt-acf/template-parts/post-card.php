<?php
/**
 * Article summary for archives and "More articles". Use inside the loop.
 *
 * Optional $args:
 * - lead: true for the large first story on the blog page.
 *
 * @package wpt-acf
 */

$wpt_lead       = ! empty( $args['lead'] );
$wpt_topic      = wpt_topic();
$wpt_standfirst = get_the_excerpt();
$wpt_has_image  = has_post_thumbnail();
$wpt_classes    = array( 'post-card' );
if ( $wpt_lead ) {
	$wpt_classes[] = 'post-card--lead';
}
if ( $wpt_has_image ) {
	$wpt_classes[] = 'post-card--image';
}
?>
<article <?php post_class( $wpt_classes ); ?> data-reveal>
	<?php if ( $wpt_has_image ) : ?>
		<a class="post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php
			the_post_thumbnail(
				$wpt_lead ? 'large' : 'medium_large',
				array(
					'class' => 'post-card__image',
					'sizes' => $wpt_lead ? '(min-width: 56rem) 55vw, 100vw' : '(min-width: 56rem) 33vw, 100vw',
				)
			);
			?>
		</a>
	<?php endif; ?>

	<div class="post-card__body">
		<p class="post-card__meta">
			<?php if ( $wpt_topic ) : ?>
				<span class="post-card__topic"><?php echo esc_html( $wpt_topic->name ); ?></span>
			<?php endif; ?>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</p>

		<?php if ( $wpt_lead ) : ?>
			<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php else : ?>
			<h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php endif; ?>

		<?php if ( $wpt_standfirst ) : ?>
			<p class="post-card__excerpt"><?php echo esc_html( $wpt_standfirst ); ?></p>
		<?php endif; ?>

		<?php if ( $wpt_lead ) : ?>
			<a class="text-link" href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Read the article', 'wpt-acf' ); ?><span class="screen-reader-text">: <?php the_title(); ?></span>
			</a>
		<?php endif; ?>
	</div>
</article>
