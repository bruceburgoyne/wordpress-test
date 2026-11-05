/**
 * Scroll reveal for the Editorial design.
 *
 * Does nothing if the visitor prefers reduced motion or the browser lacks
 * IntersectionObserver, so content is always readable.
 *
 * Only elements matched below are hidden and revealed. Don't add
 * data-reveal in templates: an element hidden that way is never observed,
 * so it would stay invisible. Add its selector here instead.
 */
( function () {
	'use strict';

	if ( ! ( 'IntersectionObserver' in window ) ) {
		return;
	}
	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	var selectors = [
		'.section h2',
		'.card',
		'.person',
		'.service',
		'.steps__item',
		'.split__image',
		'.contact-list',
		'.cta__inner > *',
		'.post-card'
	];
	var items = document.querySelectorAll( selectors.join( ',' ) );
	if ( ! items.length ) {
		return;
	}

	items.forEach( function ( el ) {
		el.setAttribute( 'data-reveal', '' );
		// Stagger siblings in the same grid or list.
		var index = Array.prototype.indexOf.call( el.parentNode.children, el );
		el.style.setProperty( '--reveal-delay', Math.min( index, 5 ) * 80 + 'ms' );
	} );

	document.documentElement.classList.add( 'js-motion' );

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'is-visible' );
					observer.unobserve( entry.target );
				}
			} );
		},
		{ rootMargin: '0px 0px -10% 0px', threshold: 0.1 }
	);

	items.forEach( function ( el ) {
		observer.observe( el );
	} );
}() );
