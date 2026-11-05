<?php
/**
 * Blog page: the page chosen as the "Posts page" in Settings > Reading.
 *
 * The header and the closing call to action come from that page's ACF fields
 * (the "Blog page" field group). The newest article leads on the first page.
 *
 * @package wpt-acf
 */

get_header();

$wpt_blog_id = wpt_blog_page_id();

if ( $wpt_blog_id ) {
	get_template_part( 'template-parts/page-header', null, array( 'post_id' => $wpt_blog_id ) );
} else {
	?>
	<section class="page-header">
		<div class="container"><h1><?php esc_html_e( 'Latest articles', 'wpt-acf' ); ?></h1></div>
	</section>
	<?php
}

get_template_part( 'template-parts/post-list', null, array( 'lead' => ! is_paged() ) );

if ( $wpt_blog_id ) {
	get_template_part( 'template-parts/cta', null, array( 'post_id' => $wpt_blog_id ) );
}

get_footer();
