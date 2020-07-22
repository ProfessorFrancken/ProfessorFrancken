<?php


declare(strict_types=1);

namespace Francken\Shared\ViewComponents\Admin;

use Illuminate\View\Component;
use Illuminate\View\View;

class Navigation extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View
    {
        $menu = config('francken.navigation.admin-menu');

        return view('admin.components.navigation')->with([
            'menu' => $menu
        ]);
    }
}
