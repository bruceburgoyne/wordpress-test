<?php
/**
 * Site footer.
 *
 * @package wpt-acf
 */

$wpt_phone   = wpt_option( 'phone' );
$wpt_email   = wpt_option( 'email' );
$wpt_address = wpt_option( 'address' );
$wpt_social  = wpt_option( 'social_links' );
$wpt_footer  = wpt_option( 'footer_text' );
?>
</main>

<footer class="site-footer">
	<div class="container site-footer__grid">
		<div>
			<p class="site-footer__name"><?php bloginfo( 'name' ); ?></p>
			<?php if ( $wpt_address ) : ?>
				<address><?php echo wpt_text( $wpt_address ); // phpcs:ignore WordPress.Security.EscapeOutput ?></address>
			<?php endif; ?>
		</div>

		<ul class="site-footer__contact">
			<?php if ( $wpt_phone ) : ?>
				<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $wpt_phone ) ); ?>"><?php echo esc_html( $wpt_phone ); ?></a></li>
			<?php endif; ?>
			<?php if ( $wpt_email ) : ?>
				<li><a href="mailto:<?php echo esc_attr( antispambot( $wpt_email ) ); ?>"><?php echo esc_html( antispambot( $wpt_email ) ); ?></a></li>
			<?php endif; ?>
		</ul>

		<?php if ( $wpt_social ) : ?>
			<ul class="site-footer__social">
				<?php foreach ( $wpt_social as $wpt_item ) : ?>
					<?php if ( ! empty( $wpt_item['url'] ) ) : ?>
						<li><a href="<?php echo esc_url( $wpt_item['url'] ); ?>" rel="noopener" target="_blank"><?php echo esc_html( $wpt_item['label'] ? $wpt_item['label'] : $wpt_item['url'] ); ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php if ( $wpt_footer ) : ?>
		<div class="container site-footer__small"><?php echo wpt_text( $wpt_footer ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
	<?php endif; ?>
</footer>
</div><!-- .site-wrap -->

<?php wp_footer(); ?>
</body>
</html>
