<x-modal name="claim-anytimer" open-with="open-claim-anytimer">
    {!!
           Form::model(
               null,
               [
                   'url' => action(
                       [\Francken\Association\Borrelcie\Http\AnytimersController::class, 'store'],
                       []
                   ),
                   'method' => 'post'
               ]
           )
    !!}

    <div class="row">
        <div class="col-md-9 col-12">
            <x-forms-autocomplete-member :members="$accounts" name="drinker" nameId="drinker_id" />
        </div>
        <div class="col-md-3 col-12">
            <x-forms.number name="amount" label="Amount" :value="1" />
        </div>
    </div>
    <x-forms.text name="reason" label="Reason" />
    <input type="hidden" name="context" value="claimed">
    <input type="hidden" name="owner_id" value="{{ $account->id }}" />

    <button class="btn btn-inverse btn-lg btn-block btn-outline-primary">
        Claim an anytimer
    </button>
    {!! Form::close() !!}
</x-modal>
