@extends('admin.layout')
@section('page-title', 'Settings')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['url' => action([\Francken\Shared\Settings\Http\Controllers\SettingsController::class, 'update'])]) !!}
                        @method('PUT')
                        @foreach ($settings as $key => $setting)
                                @if ($setting['type'] === 'toggle')
                                    <div class="form-group form-check">
                                        {!! Form::hidden($key, false)  !!}
                                        {!! Form::checkbox($key, true, $setting['value'], ['class' => 'form-check-input', 'id' => $key])  !!}
                                        <label class="form-check-label" for="{{ $key }}">
                                            {{ $setting['text'] }}
                                        </label>
                                    </div>
                                @endif
                                @if ($setting['type'] === 'text')
                                    <div class="form-group">
                                        <label for="{{ $key }}">
                                            {{ $setting['text'] }}
                                        </label>
                                        {!! Form::text($key, $setting['value'], ['class' => 'form-control', 'id' => $key]) !!}
                                    </div>
                                @endif
                        @endforeach

                        <x-forms.submit>Save</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
