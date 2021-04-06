@extends('admin.layout')
@section('page-title', 'Consumption Counter Settings')

@section('content')

    {!!
           Form::model($consumptionCounterExtra, [
               'url' => action([\Francken\Association\Members\Http\Controllers\Admin\ConsumptionCounterSettingsController::class, 'update'], ['member' => $member, 'consumptionCounterExtra' => $consumptionCounterExtra]),
               'method' => 'PUT',
               'enctype' => 'multipart/form-data'
           ])
    !!}
    <div class="card mb-3">
        <div class="card-body">
            <h4>Francken Consumption Counter settings</h4>

            <div class="row">
                <div class="col col-md-3">
                    <img
                        id="consumption-counter-image"
                        alt="Image used by consumption counter"
                        src="{{ $consumptionCounterExtra->photo_url }}"
                        class="mb-3 img-fluid rounded"
                        style="object-fit: cover"
                    />
                </div>
                <div class="col">
                    <x-forms.number name="prominent" label="Prominent" />
                    <x-forms.text name="kleur" label="Color" type="color" />

                    <x-forms.image-upload
                        name="image"
                        label="Consumption Counter image"
                        output-image-id="consumption-counter-image"
                    />

                    <x-forms.text name="bijnaam" label="Nickname" />
                    <x-forms.checkbox name="small_button" label="Small button" :value="$consumptionCounterExtra->has_small_button"/>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <x-forms.submit>Save</x-forms.submit>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
