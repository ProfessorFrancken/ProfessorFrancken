@extends('admin.layout')
@section('page-title', 'Photo albums / ' . $album->published_at->format('Y-m-d') . ' / ' . $album->title)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                {!!
                       Form::model($album, [
                           'url' => action(
                               [\Francken\Association\Photos\Http\Controllers\AdminPhotoAlbumsController::class, 'update'],
                               ['album' => $album]
                           ),
                           'method' => 'PUT',
                       ])
                !!}
                <div class="card-body">
                    @include('admin.association.photo-albums._form', ['album' => $album])
                </div>
                <div class="card-footer">
                    <x-forms.submit>Save</x-forms.submit>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
