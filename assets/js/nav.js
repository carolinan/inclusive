/**
 * Handle togglers.
 */
function InclusiveToggleButtonClick( id ) { // eslint-disable-line no-unused-vars
	var el = document.querySelector( 'button[data-uid="' + id + '"]' );
	var container = document.getElementById('site-navigation');

	InclusiveNavToggleFocusByEl( el );

	// Toggle the "toggled-on" class.
	el.classList.toggle( 'toggled-on' );
	container.classList.toggle('toggled-on');

	// Toggle aria-expanded.
	if ( el.classList.contains( 'toggled-on' ) ) {
		el.setAttribute( 'aria-expanded', 'true' );
	} else {
		el.setAttribute( 'aria-expanded', 'false' );
	}
}

window.onload = function() {
	var NavLinks = document.querySelectorAll( '.menu-item a' ),
		i;
	for ( i = 0; i < NavLinks.length; i++ ) {
		NavLinks[i].addEventListener('focus', InclusiveNavToggleFocus, true );
		NavLinks[i].addEventListener('blur', InclusiveNavToggleFocus, true );
	}
};

function InclusiveNavToggleFocus() {
	InclusiveNavToggleFocusByEl( this );
}

function InclusiveNavToggleFocusByEl( el ) {
	var isMenu = el.closest( '.primary-menu' ),
		closestSubMenu,
		closestUl,
		allOpenSubMenuButtons,
		i;

	if ( isMenu ) {
		closestSubMenu        = el.closest( '.sub-menu' );
		closestUl             = closestSubMenu ? closestSubMenu.closest( 'ul' ) : el.closest( 'ul' );
		allOpenSubMenuButtons = closestUl.querySelectorAll( '.menu-item .toggled-on' );
		for ( i = 0; i < allOpenSubMenuButtons.length; i++ ) {
			if ( null === closestSubMenu || ( closestSubMenu && closestSubMenu.parentNode.querySelector( '.menu-item .toggled-on' ) !== allOpenSubMenuButtons[ i ] ) ) {
				if ( allOpenSubMenuButtons[ i ] !== el ) {
					allOpenSubMenuButtons[ i ].classList.remove( 'toggled-on' );
					allOpenSubMenuButtons[ i ].setAttribute( 'aria-expanded', 'false' );
				}
			}
		}
	}
}


/**
 * Handle clicks on the main menu parts.
 *
 * @param {Element} el
 */
function InclusiveMenuItemExpand(el) { // eslint-disable-line no-unused-vars
	var ul = el.parentNode.parentNode.querySelector('ul'),
		expand = ('none' === window.getComputedStyle(ul).display);
	ul.style.display = expand ? 'block' : 'none';
	if (expand) {
		el.classList.add('active');
		ul.setAttribute('tabindex', '-1');
	} else {
		el.classList.remove('active');
	}
}

document.querySelectorAll('.primary-menu ul.sub-menu').forEach(function (subMenu) {
	subMenu.addEventListener('blur', function (e) {
		var prev = e.target,
			next = e.relatedTarget,
			prevUl = prev ? prev.closest('.sub-menu') : null,
			nextUl = next ? next.closest('.sub-menu') : null;

		if (prevUl && prevUl !== nextUl && (!nextUl || !prevUl.contains(nextUl))) {
			prevUl.style.display = 'none';
			prevUl.parentNode.querySelector('button').classList.remove('active');
		}
	}, true);
});
