@extends('admin.layout')
@section('page-title', "Media / {$media->basename}")

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <dl>
                        <dt>Basename</dt>
                        <dd>{{ $media->basename }}</dd>
                        <dt>Directory</dt>
                        <dd>{{ $media->directory }}</dd>
                        @if ($media->isPubliclyAccessible())
                        <dt>Url</dt>
                        <dd>
                            <a href="{{ $media->getUrl() }}" target="_blank">
                                {{ $media->getUrl() }}
                            </a>
                        </dd>
                        @endif
                        <dt>Mimetype</dt>
                        <dd>{{ $media->mime_type }}</dd>
                        <dt>Size</dt>
                        <dd>{{ $media->readableSize() }}</dd>
                        <dt>Publicly accessible?</dt>
                        <dd>{{ $media->isPubliclyAccessible() ? "Yes" : "No" }}</dd>
                    </dl>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    Associated with
                </div>

                <div class="card-body">
                    <ul>
                        @foreach ($mediables as $type => $mediable)
                            <li>
                                <strong>{{ class_basename($type) }}</strong>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-4">
            @if ($media->aggregate_type)
                <img
                    src="{{ $media->getUrl() }}"
                    class="img-thumbnail"
                >
            @endif

        </div>
    </div>
@endsection


@section('actions')
    <div class="d-flex align-items-end">
        <div class="btn-group">
            <x-forms.submit class="btn btn-info" disabled>
                Move
            </x-forms.submit>

            <x-forms.submit class="btn btn-danger" disabled>
                Delete
            </x-forms.submit>
        </div>
    </div>
@endsection
