<?php
/**
 * Site header, plus the mobile menu panel.
 *
 * On small screens a burger button opens a panel from the left that pushes
 * the page (.site-wrap) across. See assets/js/menu.js.
 *
 * @package wpt-acf
 */

$wpt_logo          = wpt_option( 'logo' );
$wpt_header_button = wpt_option( 'header_button' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>document.documentElement.classList.add('has-js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'wpt-acf' ); ?></a>

<div id="mobile-panel" class="mobile-panel" aria-label="<?php esc_attr_e( 'Menu', 'wpt-acf' ); ?>" role="dialog" aria-modal="true" inert>
	<button class="mobile-panel__close" type="button" data-menu-close>
		<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'wpt-acf' ); ?></span>
		<span class="mobile-panel__close-icon" aria-hidden="true"></span>
	</button>
	<nav class="mobile-panel__nav" aria-label="<?php esc_attr_e( 'Mobile', 'wpt-acf' ); ?>">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'mobile-panel__list',
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);
		?>
	</nav>
	<?php if ( ! empty( $wpt_header_button['url'] ) ) : ?>
		<div class="mobile-panel__cta"><?php echo wpt_link( $wpt_header_button, 'button button--arrow' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
	<?php endif; ?>
</div>

<div class="site-wrap">
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
			<?php echo wpt_link( $wpt_header_button, 'button button--small site-nav__button' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
		</nav>

		<button class="nav-toggle" type="button" aria-controls="mobile-panel" aria-expanded="false">
			<span class="screen-reader-text"><?php esc_html_e( 'Open menu', 'wpt-acf' ); ?></span>
			<span class="nav-toggle__bars" aria-hidden="true"><span></span></span>
		</button>
	</div>
</header>

<main id="main" class="site-main">
