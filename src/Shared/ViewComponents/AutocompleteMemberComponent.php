<?php

declare(strict_types=1);

namespace Francken\Shared\ViewComponents;

use Francken\Association\LegacyMember;
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

        if ($members === null) {
            $this->members = collect();
        } else {
            // Laravel automatically injects an empty Collection if we omit the
            // members attribute. In this case we want to default to a
            // autocomplete containing all members
            $this->members = $members->isNotEmpty()
                ? $members
                : LegacyMember::autocomplete();
        }
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
