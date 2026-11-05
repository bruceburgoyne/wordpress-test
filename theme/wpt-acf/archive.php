<?php
/**
 * Topic (category), tag, author and date archives for articles.
 *
 * @package wpt-acf
 */

get_header();

if ( is_category() ) {
	$wpt_label = __( 'Topic', 'wpt-acf' );
} elseif ( is_tag() ) {
	$wpt_label = __( 'Tag', 'wpt-acf' );
} elseif ( is_author() ) {
	$wpt_label = __( 'Articles by', 'wpt-acf' );
} else {
	$wpt_label = __( 'Archive', 'wpt-acf' );
}
$wpt_description = get_the_archive_description();
?>
<section class="page-header">
	<div class="container">
		<div>
			<p class="kicker"><?php echo esc_html( $wpt_label ); ?></p>
			<h1><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
		</div>
		<?php if ( $wpt_description ) : ?>
			<div class="lead"><?php echo wp_kses_post( $wpt_description ); ?></div>
		<?php endif; ?>
	</div>
</section>
<?php
get_template_part( 'template-parts/post-list' );

$wpt_blog_id = wpt_blog_page_id();
if ( $wpt_blog_id ) {
	get_template_part( 'template-parts/cta', null, array( 'post_id' => $wpt_blog_id ) );
}

get_footer();
