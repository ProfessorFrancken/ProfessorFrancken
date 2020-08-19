@extends('admin.layout')
@section('page-title', 'Settings')

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['url' => action([\Francken\Shared\Settings\Http\Controllers\SettingsController::class, 'update'])]) !!}
            @method('PUT')
            @foreach ($settings as $key => $setting)
                @if ($setting['type'] === 'toggle')
                    <x-forms.checkbox :name="$key" :value="$setting['value']" :label="$setting['text']" />
                @endif
                @if ($setting['type'] === 'text')
                    <x-forms.text :name="$key" :value="$setting['value']" :label="$setting['text']" />
                @endif
            @endforeach

            <x-forms.submit>Save</x-forms.submit>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
