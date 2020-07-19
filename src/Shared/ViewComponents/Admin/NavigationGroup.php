<?php

declare(strict_types=1);

namespace Francken\Shared\ViewComponents\Admin;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\Component;

class NavigationGroup extends Component
{
    public array $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $item, Guard $auth)
    {
        $account = $auth->user();

        $this->item = $item;
        $this->item['items'] = array_filter($this->item['items'], function (array $item) use ($account) : bool {
            if ( ! $item['works']) {
                return $account->can('super-admin-read');
            }

            return $account->can($item['can'] ?? 'can-access-dashboard');
        });
    }

    public function isActive(array $item) : bool
    {
        return request()->segment(3) == $item['url'];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('admin.components.navigation-group');
    }
}
