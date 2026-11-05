<?php
/**
 * Single article. The body comes from the block editor; the standfirst comes
 * from ACF; the closing call to action comes from the blog page's ACF fields.
 *
 * @package wpt-acf
 */

get_header();

while ( have_posts() ) :
	the_post();
	$wpt_topic      = wpt_topic();
	$wpt_standfirst = wpt_standfirst();
	$wpt_minutes    = wpt_reading_time();
	$wpt_tags       = get_the_tags();
	?>
	<article <?php post_class( 'article' ); ?>>
		<header class="article-header container">
			<?php if ( $wpt_topic ) : ?>
				<p class="kicker"><a href="<?php echo esc_url( get_category_link( $wpt_topic ) ); ?>"><?php echo esc_html( $wpt_topic->name ); ?></a></p>
			<?php endif; ?>

			<h1 class="article-header__title"><?php the_title(); ?></h1>

			<?php if ( $wpt_standfirst ) : ?>
				<p class="lead article-header__standfirst"><?php echo esc_html( $wpt_standfirst ); ?></p>
			<?php endif; ?>

			<p class="byline">
				<span><?php esc_html_e( 'By', 'wpt-acf' ); ?> <?php the_author(); ?></span>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<span>
					<?php
					/* translators: %d: minutes */
					echo esc_html( sprintf( _n( '%d minute read', '%d minute read', $wpt_minutes, 'wpt-acf' ), $wpt_minutes ) );
					?>
				</span>
			</p>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="article-image">
				<?php
				the_post_thumbnail(
					'full',
					array(
						'class'         => 'article-image__img',
						'sizes'         => '(min-width: 72rem) 64rem, 100vw',
						'fetchpriority' => 'high',
						'loading'       => 'eager',
					)
				);
				$wpt_caption = wp_get_attachment_caption( get_post_thumbnail_id() );
				if ( $wpt_caption ) :
					?>
					<figcaption><?php echo esc_html( $wpt_caption ); ?></figcaption>
				<?php endif; ?>
			</figure>
		<?php endif; ?>

		<div class="article-body">
			<?php the_content(); ?>
		</div>

		<?php if ( $wpt_tags ) : ?>
			<footer class="article-footer">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Tags', 'wpt-acf' ); ?></h2>
				<ul class="tag-list">
					<?php foreach ( $wpt_tags as $wpt_tag ) : ?>
						<li><a href="<?php echo esc_url( get_tag_link( $wpt_tag ) ); ?>"><?php echo esc_html( $wpt_tag->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</footer>
		<?php endif; ?>
	</article>
	<?php
	get_template_part( 'template-parts/related-posts', null, array( 'topic' => $wpt_topic ) );
endwhile;

$wpt_blog_id = wpt_blog_page_id();
if ( $wpt_blog_id ) {
	get_template_part( 'template-parts/cta', null, array( 'post_id' => $wpt_blog_id ) );
}

get_footer();
