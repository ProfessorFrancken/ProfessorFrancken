<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="deducted_at">Deducted at</label>
            {!!
               Form::date(
                   'deducted_at',
                   optional($deduction->deducted_at)->format('Y-m-d'),
                   ['class' => 'form-control', 'id' => 'deducted_at']
               );
            !!}

            <small class="form-text text-muted">
                The approximate date at which the money will be deducted from our members' bank accounts.
            </small>
        </div>

        <div class="form-group">
            <label for="deduction" class="h5">
                Deduction file
            </label>

            {!! Form::file('deduction', ['class' => 'form-control-file']) !!}
            <small class="form-text text-muted">
                The file that you've uploaded to ABN Amro.
            </small>
        </div>

        <h3 class="h5">Deduction period</h3>

        <small class="form-text text-muted mb-2">
            The period over which this deduction takes place.
            This period will be mentioned in the email sent to our members.
        </small>
        <div class="row">
            <div class="form-group col">
                <label for="deduction_from">Deduction from</label>
                {!!
                   Form::date(
                       'deduction_from',
                       optional($deduction->deduction_from)->format('Y-m-d'),
                       ['class' => 'form-control', 'id' => 'deduction_from']
                   );
                !!}
            </div>
            <div class="form-group col">
                <label for="deduction_to">Deduction to</label>
                {!!
                   Form::date(
                       'deduction_to',
                       optional($deduction->deduction_to)->format('Y-m-d'),
                       ['class' => 'form-control', 'id' => 'deduction_to']
                   );
                !!}
            </div>
        </div>

        @if ($deduction->exists)
        @endif
    </div>
</div>


