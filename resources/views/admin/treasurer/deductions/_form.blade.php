<div class="row">
    <div class="col">
        <x-forms.date
            name="deducted_at"
            label="Deducted at"
            :value="optional($deduction->deducted_at)->format('Y-m-d')"
        >
            <x-slot name="help">
                The approximate date at which the money will be deducted from our members' bank accounts.
            </x-slot>
        </x-forms.date>

        <x-forms.form-group name="deduction">
            {!! Form::file('deduction', ['class' => 'form-control-file']) !!}

            <x-slot name="label">
                <h3 class="h5 mb-0">Deduction file</h3>
            </x-slot>

            <x-slot name="help">
                The file that you've uploaded to ABN Amro.
            </x-slot>
        </x-forms.form-group>

        <h3 class="h5">Deduction period</h3>

        <small class="form-text text-muted mb-2">
            The period over which this deduction takes place.
            This period will be mentioned in the email sent to our members.
        </small>
        <div class="row">
            <div class="col">
                <x-forms.date
                    name="deduction_from"
                    label="Deduction from"
                    :value="optional($deduction->deduction_from)->format('Y-m-d')"
                />
            </div>
            <div class="col">
                <x-forms.date
                    name="deduction_to"
                    label="Deduction to"
                    :value="optional($deduction->deduction_to)->format('Y-m-d')"
                />
            </div>
        </div>

        @if ($deduction->exists)
        @endif
    </div>
</div>


