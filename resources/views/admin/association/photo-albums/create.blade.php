@extends('admin.layout')
@section('page-title', 'Albums / create')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                {!! Form::model($album, [
                        'url' => action([\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'store']),
                        'method' => 'post',
                        ])
                !!}

                <div class="card-body">
                    @include('admin.association.photo-albums._form', ['album' => $album])

                </div>
                <div class="card-footer">
                    <x-forms.submit>Add album</x-forms.submit>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
