<div class="row">
    @isset ($member)
        {!!
               Form::hidden(
                   'member_id',
                   isset($member) ? $member->member_id : null,
                   ['class' => 'member_id']
               )
        !!}
    @else
    <div class="col">
        <x-forms-autocomplete-member />
    </div>
    @endisset

    <div class="form-group col">
        <label for="function">Function</label>
        {!! Form::text('function', null, ['class' => 'form-control', 'placeholder' => 'President', 'id' => 'function']) !!}
    </div>
    <div class="form-group col">
        <label>Install date</label>
        {!!
           Form::date(
               'installed_at',
               $committee->board->installed_at->format('Y-m-d'),
               ['class' => 'form-control', 'id' => 'installed_at']
           );
        !!}
        <small class="form-text text-muted">
            By defautl we've selected the install dater of the board, but you can ofcourse choose a different install date
        </small>
    </div>
    @isset ($member)
    <div class="form-group col">
        <label>Decharge date</label>
        {!!
           Form::date(
               'decharged_at',
               null,
               ['class' => 'form-control', 'id' => 'decharge_at']
           );
        !!}
        <small class="form-text text-muted">
            Typically this is the same date as the committee's board is demissioned, unless the member has left the committe earlier.
        </small>
    </div>
    @endisset
</div>
