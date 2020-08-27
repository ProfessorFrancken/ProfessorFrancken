<x-modal name="use-anytimer-{{ $anytimer->drinker->id }}" open-with="use-anytimer-{{ $anytimer->drinker->id }}">
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

    <x-forms.text name="reason" label="Reason" />
    <input type="hidden" name="context" value="used">
    <input type="hidden" name="owner_id" value="{{ $anytimer->owner_id }}" />
    <input type="hidden" name="drinker_id" value="{{ $anytimer->drinker_id }}" />
    <input type="hidden" name="amount" value="-1" />

    <button class="btn btn-inverse btn-lg btn-block btn-outline-primary">
        Use anytimer
    </button>
    {!! Form::close() !!}
</x-modal>
