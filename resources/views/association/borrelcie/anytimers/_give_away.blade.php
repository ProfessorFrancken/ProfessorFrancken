<x-modal name="give-anytimer" open-with="open-give-anytimer">
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
            <x-forms-autocomplete-member :members="$accounts" name="owner" nameId="owner_id" />
        </div>
        <div class="col-md-3 col-12">
            <x-forms.number name="amount" label="Amount" :value="1" />
        </div>
    </div>
    <x-forms.text name="reason" label="Reason" />
    <input type="hidden" name="context" value="given">
    <input type="hidden" name="drinker_id" value="{{ $account->id }}" />

    <button class="btn btn-inverse btn-lg btn-block btn-outline-primary">
        Give away an anytimer
    </button>
    {!! Form::close() !!}
</x-modal>
