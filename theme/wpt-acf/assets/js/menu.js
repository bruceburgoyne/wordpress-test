/**
 * Mobile menu: a panel that slides in from the left and pushes the page across.
 *
 * - The burger button opens it; the close button, Escape, a click on the
 *   pushed page, choosing a link, or widening the screen closes it.
 * - While open, the page is inert, so keyboard focus stays in the panel.
 * - Focus moves to the first link on open and back to the burger on close.
 * - Menu items get a stagger index (--i) for their entrance animation, which
 *   the CSS switches off for visitors who prefer reduced motion.
 */
( function () {
	'use strict';

	var root = document.documentElement;
	var toggle = document.querySelector( '.nav-toggle' );
	var panel = document.getElementById( 'mobile-panel' );
	var page = document.querySelector( '.site-wrap' );
	if ( ! toggle || ! panel || ! page ) {
		return;
	}

	var desktop = window.matchMedia( '(min-width: 48rem)' );
	var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' );
	var openLabel = toggle.querySelector( '.screen-reader-text' );
	var openText = openLabel ? openLabel.textContent : '';

	// Stagger index for each animated item in the panel.
	panel.querySelectorAll( '.mobile-panel__list > li, .mobile-panel__cta' ).forEach( function ( el, i ) {
		el.style.setProperty( '--i', i );
	} );

	function isOpen() {
		return root.classList.contains( 'menu-open' );
	}

	function open() {
		if ( isOpen() ) {
			return;
		}
		panel.inert = false;
		page.inert = true;
		root.classList.add( 'menu-open' );
		toggle.setAttribute( 'aria-expanded', 'true' );

		var first = panel.querySelector( '.mobile-panel__list a' );
		var delay = reduceMotion.matches ? 0 : 250;
		window.setTimeout( function () {
			if ( isOpen() && first ) {
				first.focus( { preventScroll: true } );
			}
		}, delay );
	}

	function close( returnFocus ) {
		if ( ! isOpen() ) {
			return;
		}
		root.classList.remove( 'menu-open' );
		toggle.setAttribute( 'aria-expanded', 'false' );
		page.inert = false;
		panel.inert = true;
		if ( returnFocus !== false ) {
			toggle.focus( { preventScroll: true } );
		}
	}

	toggle.addEventListener( 'click', function () {
		if ( isOpen() ) {
			close();
		} else {
			open();
		}
	} );

	panel.querySelectorAll( '[data-menu-close]' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function () {
			close();
		} );
	} );

	// Choosing a link closes the panel (useful for in-page anchors).
	panel.addEventListener( 'click', function ( event ) {
		if ( event.target.closest( 'a' ) ) {
			close( false );
		}
	} );

	// A click anywhere outside the panel (the pushed page) closes it.
	document.addEventListener( 'click', function ( event ) {
		if ( isOpen() && ! panel.contains( event.target ) && ! toggle.contains( event.target ) ) {
			close();
		}
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' === event.key && isOpen() ) {
			close();
		}
	} );

	// If the screen widens to desktop, the panel is no longer needed.
	function onBreakpoint( mq ) {
		if ( mq.matches ) {
			close( false );
		}
	}
	if ( desktop.addEventListener ) {
		desktop.addEventListener( 'change', onBreakpoint );
	} else if ( desktop.addListener ) {
		desktop.addListener( onBreakpoint );
	}

	// Keep the burger's accessible name in step with its state.
	new MutationObserver( function () {
		if ( openLabel ) {
			openLabel.textContent = isOpen() ? openText.replace( /open/i, 'Close' ) : openText;
		}
	} ).observe( root, { attributes: true, attributeFilter: [ 'class' ] } );
}() );
