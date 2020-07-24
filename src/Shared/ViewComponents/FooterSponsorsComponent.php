<?php

declare(strict_types=1);

namespace Francken\Shared\ViewComponents;

use Francken\Extern\SponsorOptions\Footer;
use Illuminate\View\Component;

class FooterSponsorsComponent extends Component
{
    public array $footer = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->footer = Footer::query()
            ->where('is_enabled', true)
            ->with(['partner'])
            ->get()
            ->map(fn (Footer $footer) => [
                'footer-link' => $footer->referral_url,
                'footer-logo' => $footer->logo,
                'name' => $footer->partner->name,
            ])
            ->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('layout._sponsors');
    }
}
