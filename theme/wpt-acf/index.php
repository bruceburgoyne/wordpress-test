<?php
/**
 * Fallback template (posts, archives, search, 404).
 *
 * @package wpt-acf
 */

get_header();
?>
<section class="page-header">
	<div class="container">
		<h1><?php echo is_404() ? esc_html__( 'Page not found', 'wpt-acf' ) : esc_html( wp_get_document_title() ); ?></h1>
	</div>
</section>

<section class="section">
	<div class="container container--narrow prose">
		<?php if ( have_posts() && ! is_404() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<?php if ( ! is_singular() ) : ?>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
					<?php else : ?>
						<?php the_content(); ?>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Sorry, there is nothing here.', 'wpt-acf' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return to the home page', 'wpt-acf' ); ?></a>.</p>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
