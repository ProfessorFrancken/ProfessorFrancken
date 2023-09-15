@props([
    'name',
    'label',
    'value' => null,
    'options' => [],
    'placeholder' => '',
    'help' => '',
])

<x-forms.form-group :name="$name" :label="$label" :help="$help">
    <div class="d-flex flex-column flex-sm-row align-items-start mt-2">
        @foreach ($options as $optionName => $label)
            <div class="form-check mr-3">
                {!!
                       Form::radio(
                           $name,
                           $optionName,
                           false,
                           [
                               'id' => "{$name}-{$optionName}",
                               'class' => 'form-check-input',
                               'required',
                           ]
                       )
                !!}
                <label class="form-check-label" for="{{ $name  }}-{{ $optionName  }}">
                    {{ $label  }}
                </label>
            </div>
        @endforeach
    </div>
</x-forms.form-group>
