<?php

declare(strict_types=1);

namespace Francken\Shared\ViewComponents\Admin;

use Francken\Auth\Account;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\View\Component;
use Webmozart\Assert\Assert;

class NavigationGroup extends Component
{
    public array $item;
    private ?string $activeSegment;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $item, Guard $auth, Request $request)
    {
        $this->activeSegment = $request->segment(3);
        $account = $auth->user();

        Assert::isInstanceOf($account, Account::class);

        $this->item = $item;
        $this->item['items'] = array_filter(
            $this->item['items'] ?? $this->item['subItems'],
            function (array $item) use ($account) : bool {
                if (isset($item['works']) && ! $item['works']) {
                    return $account->can('super-admin-read');
                }

                return $account->can($item['can'] ?? 'can-access-dashboard');
            });
    }

    public function isActive(array $item) : bool
    {
        return $this->activeSegment == $item['url'];
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
