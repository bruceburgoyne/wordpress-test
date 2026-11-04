<?php
/**
 * Site header.
 *
 * @package wpt-acf
 */

$wpt_logo = wpt_option( 'logo' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'wpt-acf' ); ?></a>

<header class="site-header">
	<div class="container site-header__inner">
		<a class="site-header__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
			if ( $wpt_logo ) {
				echo wpt_image( $wpt_logo, 'medium', 'site-header__logo' ); // phpcs:ignore WordPress.Security.EscapeOutput
			} else {
				bloginfo( 'name' );
			}
			?>
		</a>

		<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'wpt-acf' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</nav>
	</div>
</header>

<main id="main" class="site-main">
