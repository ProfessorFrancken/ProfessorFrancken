<div class="login-modal {{ $name }}-modal" role="dialog" >
    <div class="login-modal__body {{ $name }}-modal__body">
        <div class="text-right">
            <button class="login-modal__close {{ $name }}__close">
                <span>&times;</span>
            </button>
        </div>

        <div class="login-modal__content">
            {!! $slot !!}
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    (function() {
        const Modal = (function() {
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

                open = true;
            }

            function closeModal() {
                // Hide the modal
                $modal.classList.remove("login-modal--visible");

                // Untrap the tab focus by removing tabindex=-1. You should restore previous values if an element had them.
                const focusableElements = $main.querySelectorAll(FOCUSABLE_SELECTORS);
                focusableElements.forEach(el => el.removeAttribute('tabindex'));

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
            const openModalBtns = document.querySelectorAll('.{{ $openWith }}');
            const closeModalBtn = document.querySelector('.{{ $name }}__close');
            const modal = document.querySelector('.{{ $name }}-modal');
            const main = document.querySelector('main');
            const body = document.querySelector('.{{ $name }}-modal__body');

            Modal.init(openModalBtns, closeModalBtn, modal, body, main);
        }

        enableLoginModal();
    })();
</script>
@endpush
