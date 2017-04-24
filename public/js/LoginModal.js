Modal = (function() {
    const FOCUSABLE_SELECTORS = 'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]';

    var $modal, $main;

    function openModal(e) {
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
    }

    function closeModal(e) {
		    // Stop bubbling up the DOM.
		    e.stopPropagation();
		    e.preventDefault();

        // Hide the modal
        $modal.classList.remove("login-modal--visible");

        // Untrap the tab focus by removing tabindex=-1. You should restore previous values if an element had them.
        const focusableElements = $main.querySelectorAll(FOCUSABLE_SELECTORS);
        focusableElements.forEach(el => el.removeAttribute('tabindex'));

        // Untrap screen reader focus
        $modal.setAttribute('aria-hidden', 'true');
        $main.removeAttribute('aria-hidden');
    }


    return {
        init: function(openModalBtns, closeModalBtn, modal, main) {
            $modal = modal;
            $main = main;

            // We want to listen to both the mobile and desktop login button
            openModalBtns.forEach(function(btn) {
                btn.addEventListener('click', openModal);
            });

            closeModalBtn.addEventListener('click', closeModal);
        }
    };
})();

// Open this pen in debug mode for testing
// http://codepen.io/noahblon/debug/b7896f6eb7f0a5bd84e245825ee357cd
// This is a sketch of some principles of an accessible modal - trying to keep it simple.  For a more complete demonstration, check out: https://github.com/gdkraus/accessible-modal-dialog

function enableLoginModal() {
    const openModalBtns = document.querySelectorAll('.login-link');
    const closeModalBtn = document.querySelector('.login-modal__close');
    const modal = document.querySelector('.login-modal');
    const main = document.querySelector('main');

    Modal.init(openModalBtns, closeModalBtn, modal, main);
}

enableLoginModal();
