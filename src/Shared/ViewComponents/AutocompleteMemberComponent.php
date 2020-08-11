<?php

declare(strict_types=1);

namespace Francken\Shared\ViewComponents;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class AutocompleteMemberComponent extends Component
{
    public string $name;
    public string $nameId;
    public ?string $value;
    public ?string $valueId;
    public string $placeholder;
    public ?string $label;
    public ?Collection $members;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name = 'member',
        string $nameId = 'member_id',
        ?string $value = null,
        ?string $valueId = null,
        string $placeholder = 'Member',
        ?string $label = 'Member',
        ?Collection $members = null
    ) {
        $this->name = $name;
        $this->nameId = $nameId;
        $this->value = $value;
        $this->valueId = $valueId;
        $this->placeholder = $placeholder;
        $this->label = $label;
        $this->members = $members ?? collect();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.autocomplete-member');
    }
}
