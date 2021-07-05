@extends('layout.one-column-layout')
@section('title', "Soundboard - " . $soundboard->name . " - T.F.V. 'Professor Francken'")

@section('content')
    <h3 class="section-header section-header--centered">
        {{ $soundboard->name }}
    </h3>
    <h5 class="text-center mb-4">Soundboard</h5>
    <div class="my-5">
        <style>
            .soundboard-grid {
                display: grid;
                grid-gap: 1rem;
                grid-template-columns: repeat(auto-fill, minmax(12em, 1fr));
            }
            @media only screen and (max-width: 880px) {
            .soundboard-grid {
                grid-template-columns: repeat(auto-fill, minmax(8em, 1fr));
            }
            }
            @media only screen and (max-width: 480px) {
            .soundboard-grid {
                grid-template-columns: repeat(auto-fill, minmax(6em, 1fr));
            }
            }
            .soundboard-grid > button {
                background: black;
                padding: 0;
                position: relative;
                border-radius: .5em;
            }

            .soundboard-grid > button::before {
                content: "";
                display: block;
                padding-bottom: 100%;
            }
            .soundboard-grid > button img {
                position: absolute;
                max-width: 100%;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            .soundboard-grid > button span {
                position: absolute;
                max-width: 100%;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            .soundboard-grid-edit {
                top: 0; right: 0; position: absolute; font-size: 0.8rem; opacity: 0.3
            }
            .soundboard-grid-edit:hover {
                opacity: 1.0
            }
        </style>

        <script>
            console.log("HOI")
            function play(id) {
                console.log("HOIOHI")
                var audio = document.getElementById(id);
                audio.play();
            }
        </script>

        <div class="soundboard-grid" >
            @foreach($soundboard->sounds as $s)
                <button style="background: {{ $s->css_background ?? '#aaa' }}; color: {{ $s->css_foreground ?? 'black'  }};" class="overflow-hidden btn btn-text shadow-sm border-0" onclick="play('sound_{{ $s->id  }}')">
                    <audio id="sound_{{ $s->id }}" src="{{ $s->audio }}"></audio>
                    @if ($s->image)
                        <img src="{{  $s->image }}" alt="" class="w-100 h-100">
                    @endif
                    <span>
                        <i class="far fa-play-circle"></i>
                        {{ $s->name  }}
                    </span>
                    <a href="{{  action([\Francken\Association\Soundboards\Http\SoundsController::class, 'edit'], ['soundboard' => $soundboard, 'sound' => $s]) }}" class="p-2 pl-3 pb-3 soundboard-grid-edit">
                        <i class="fas fa-pen"></i>
                    </a>
                </button>
            @endforeach
        </div>
    </div>


    <div class="bg-light p-4 mt-5 pt-0 border">
        {!!
               Form::model($sound, [
                   'url' => action(
                       [\Francken\Association\Soundboards\Http\SoundsController::class, 'store'],
                       ['soundboard' => $soundboard]
                   ),
                   'method' => 'POST',
                   'enctype' => 'multipart/form-data'
               ])
        !!}
        <h4>Upload audio</h4>
        @include('association.soundboards._form', ['soundboard' => $soundboard, 'sound' => $sound])

        <x-forms.submit>Add sound</x-forms.submit>
        {!! Form::close() !!}
    </div>
@endsection
