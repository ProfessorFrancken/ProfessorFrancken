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


    <div class="col">
        <x-forms.text name="function" label="Function" placeholder="President" />
    </div>
    <div class="col">
        <x-forms.date name="installed_at" label="Install date" :value="$committee->board->installed_at->format('Y-m-d')">
            <x-slot name="help">
                By defautl we've selected the install dater of the board, but you can ofcourse choose a different install date
            </x-slot>
        </x-forms.date>
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
