<?php
/**
 * Default page template: page header plus a single body text field.
 *
 * @package wpt-acf
 */

get_header();
get_template_part( 'template-parts/page-header' );

$wpt_body = wpt_field( 'body' );

if ( $wpt_body ) :
	?>
	<section class="section">
		<div class="container container--narrow prose"><?php echo wp_kses_post( $wpt_body ); ?></div>
	</section>
	<?php
endif;

get_footer();
