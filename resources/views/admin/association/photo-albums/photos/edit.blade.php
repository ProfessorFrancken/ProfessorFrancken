@extends('admin.layout')
@section('page-title', 'Photo albums / ' . $album->published_at->format('Y-m-d') . ' / ' . $album->title . ' / Photos / ' . $photo->name . ' / Edit')

@section('content')
    <div class="row">
        <div class="col-4">
            <div class="card">
                {!!
                       Form::model($photo, [
                           'url' => action(
                               [\Francken\Association\Photos\Http\Controllers\AdminPhotosController::class, 'update'],
                               ['album' => $album, 'photo' => $photo]
                           ),
                           'method' => 'PUT',
                       ])
                !!}

                <div class="card-body">
                    <x-forms.text name="name" label="Name" />
                    <x-forms.radio-group
                        name='visibility'
                        label="Visibility"
                        :options="['members-only' => 'Members only', 'private' => 'Private', 'public' => 'Public']"
                        help="Setting visibility to private makes the photo no longer visible to users. Members only will make the photo only visible to members that are logged in while public will be visible by anyone."
                    />
                </div>
                <div class="card-footer">
                    <x-forms.submit>Update</x-forms.submit>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="col-8">
            @include('admin.association.photo-albums._photo', ['photo' => $photo, 'href' => $photo->src(),
            'title' => $photo->name,
            ])
        </div>

    </div>
    {!!
           Form::model(
               $album,
               [
                   'url' => action(
                       [\Francken\Association\Photos\Http\Controllers\AdminPhotosController::class, 'destroy'],
                       ['album' => $album, 'photo' => $photo]
                   ),
                   'method' => 'post'
               ]
           )
    !!}
    @method('DELETE')
    <p class="mt-2 text-muted d-flex align-items-center justify-content-end">
        Click <button
                  class="btn btn-text px-1"
                  onclick='return confirm("Are you sure you want to remove this photo?");'
              >here</button> to remove this photo.
    </p>
    {!! Form::close() !!}
@endsection
