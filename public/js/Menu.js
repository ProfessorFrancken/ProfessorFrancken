// From gsvnet
Menu = (function(){
	  var activeClass = 'navigation-list__item--active-sub-list',
		    $mainMenu;

	  function collapse(){
        collapseSubMenu();
		    $mainMenu.removeClass('navigation-list--active');
	  }

    function collapseSubMenu() {
        console.log('collapse sub menu');
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
		    // Stop bubbling up the DOM.
		    e.stopPropagation();
		    e.preventDefault();

		    // Check if event is already handled
        if(e.handled !== true) {
			      $mainMenu.toggleClass('navigation-list--active');
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
					          if (e.keyCode == 27) { collapse(); }
				        }
			      });
		    }
	  }
})();

function overall() {
	  $mainMenu = $('#main-menu');

	  Menu.init($mainMenu, $('.navigation-sub-list__toggle'), $('#navbar-toggler'));
}

overall();
