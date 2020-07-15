<?php

declare(strict_types=1);

namespace Francken\Shared\ViewComponents;

use Francken\Extern\CompanyRepository;
use Illuminate\View\Component;

class FooterSponsorsComponent extends Component
{
    public $footer = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CompanyRepository $companies)
    {
        $this->footer = array_map(
            function (array $company) {
                return [
                    'footer-link' => $company['footer-link'],
                    'footer-logo' => $company['footer-logo'],
                    'name' => $company['name'],
                ];
            },
            $companies->forFooter()
        );
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
