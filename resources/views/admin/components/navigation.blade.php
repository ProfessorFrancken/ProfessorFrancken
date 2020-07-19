<div class="mobile-navigation">
    <div class="d-flex d-md-none justify-content-end align-items-center bg-dark-primary">
        <div class="ml-3 py-3 px-4 bg-primary text-white mobile-menu-button">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</div>

<nav class="styled-navigation francken-navigation">
    <div class="d-flex d-md-none justify-content-end align-items-center bg-dark-primary">
        <div class="ml-3 py-3 px-4 bg-primary text-white mobile-menu-button">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    <ul class="navigation-items list-unstyled text-left d-md-flex flex-column mb-0 pb-2 text-muted bg-primary list-unstyled w-100">
        @foreach ($menu as $item)
            <x-admin-navigation-group :item="$item" />
        @endforeach
    </ul>
</nav>

@push('scripts')
<script type="text/javascript">
// From gsvnet
    const Menu = (function(){
        var activeClass = 'navigation-list__item--active-sub-list';
        var $mainMenu;

        function collapse(e){
            if (e.isPropagationStopped()) {
                return;
            }

            collapseSubMenu();
            $mainMenu.removeClass('navigation-active');
        }

        function collapseSubMenu() {
            $('.' + activeClass).removeClass(activeClass);
        }

        function showSubMenu(e){
            // Stop bubbling up the DOM.
            e.stopPropagation();
            e.preventDefault();

            // Check if event is already handled
            if(e.handled !== true) {
                // Save jQuery instance of element
                $this = $(this);
                $parent = $this.parent();

                // Check if current menu is active
                if($parent.hasClass(activeClass)){
                    $this.attr('aria-expanded', false);
                    $parent.removeClass(activeClass);
                } else {
                    // Remove active class from other menu
                    collapseSubMenu();

                    // Make menu active
                    $this.attr('aria-expanded', true);
                    $parent.addClass(activeClass);
                }

                e.handled = true;
            } else {
                return false;
            }
        }

        function showMenu(e){
            console.log("showing menu")
            // Stop bubbling up the DOM.
            e.stopPropagation();
            e.preventDefault();

            // Check if event is already handled
            if(e.handled !== true) {
                $mainMenu.toggleClass('navigation-active');
                e.handled = true;
            } else {
                return false;
            }
        }

        return {
            // Initializes the menu
            init: function(menu, carets, toggler) {
                $mainMenu = menu;

                if (Modernizr.touch)
                {
                    carets.on('touchstart', showSubMenu);
                    toggler.on('touchstart', showMenu);
                } else {
                    carets.on('click', showSubMenu);
                    toggler.on('click', showMenu);
                }

                menu.click(function(e){
                    e.stopPropagation();
                });

                // Remove menu when document clicked or when escape is pressed
                $('html').on({
                    click: collapse,
                    keyup: function(e) {
                        // Check for escape
                        if (e.keyCode == 27) { collapse(e); }
                    }
                });
            }
        }
    })();

    function overall() {
        $mainMenu = $('.francken-navigation');

        Menu.init($mainMenu, $('.navigation-sub-list__toggle'), $('.mobile-menu-button'));
    }

    overall();
</script>


@endpush
