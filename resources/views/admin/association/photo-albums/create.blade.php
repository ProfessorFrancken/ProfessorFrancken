@extends('admin.layout')
@section('page-title', 'Albums / create')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!! Form::model($album, [
                            'url' => action([\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'store']),
                            'method' => 'post',
                            ])
                    !!}

                        @include('admin.association.photo-albums._form', ['album' => $album])

                        <x-forms.submit>Add album</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
