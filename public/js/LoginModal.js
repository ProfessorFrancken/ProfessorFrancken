Modal = (function() {
    const FOCUSABLE_SELECTORS = 'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]';

    var $modal, $main;
    var open = false;

    function openModalHandler(e) {
		    // Stop bubbling up the DOM.
		    e.stopPropagation();
		    e.preventDefault();

        // show the modal
        $modal.classList.add("login-modal--visible");

        // Focus the first element within the modal. Make sure the element is visible and doesnt have focus disabled (tabindex=-1);
        $modal.querySelector(FOCUSABLE_SELECTORS).focus();

        // Trap the tab focus by disable tabbing on all elements outside of your modal.  Because the modal is a sibling of main, this is easier. Make sure to check if the element is visible, or already has a tabindex so you can restore it when you untrap.
        const focusableElements = $main.querySelectorAll(FOCUSABLE_SELECTORS);
        focusableElements.forEach(el => el.setAttribute('tabindex', '-1'));

        // Trap the screen reader focus as well with aria roles. This is much easier as our main and modal elements are siblings, otherwise you'd have to set aria-hidden on every screen reader focusable element not in the modal.
        $modal.removeAttribute('aria-hidden');
        $main.setAttribute('aria-hidden', 'true');

        open = true;
    }

    function closeModal() {
        // Hide the modal
        $modal.classList.remove("login-modal--visible");

        // Untrap the tab focus by removing tabindex=-1. You should restore previous values if an element had them.
        const focusableElements = $main.querySelectorAll(FOCUSABLE_SELECTORS);
        focusableElements.forEach(el => el.removeAttribute('tabindex'));

        // Untrap screen reader focus
        $modal.setAttribute('aria-hidden', 'true');
        $main.removeAttribute('aria-hidden');

        open = false;
    }

    function closeModalHandler(e) {
        if (! open) {
            return;
        }

		    // Stop bubbling up the DOM.
		    e.stopPropagation();
		    e.preventDefault();

        closeModal();
    }


    return {
        init: function(openModalBtns, closeModalBtn, modal, body, main) {
            $modal = modal;
            $main = main;

            // We want to listen to both the mobile and desktop login button
            openModalBtns.forEach(function(btn) {
                btn.addEventListener('click', openModalHandler);
            });

            closeModalBtn.addEventListener('click', closeModalHandler);

            // body.click(function(e) {
            body.addEventListener('click', function(e) {
				        e.stopPropagation();
            });

			      // Remove menu when document clicked or when escape is pressed
			      $('html').on({
				        click: closeModalHandler,
				        keyup: function(e) {
					          // Check for escape
					          if (e.keyCode == 27) { closeModalHandler(e); }
				        }
			      });
        }
    };
})();

function enableLoginModal() {
    const openModalBtns = document.querySelectorAll('.login-link');
    const closeModalBtn = document.querySelector('.login-modal__close');
    const modal = document.querySelector('.login-modal');
    const main = document.querySelector('main');
    const body = document.querySelector('.login-modal__body');
    // const body = $('.login-modal__body')

    Modal.init(openModalBtns, closeModalBtn, modal, body, main);
}

enableLoginModal();
