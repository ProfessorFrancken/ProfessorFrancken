@extends('admin.layout')
@section('page-title', 'Albums / create / ' . $year)

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>No albums found</h3>
                    <p>
                        Either nextcloud has no albums for the year {{ $year }} or they've already been imported.
                        To create a new album take the following steps:
                    </p>
                    <ol>
                        <li>Upload the new album to nextcloud under the <code>images/albums/{{ $year }}</code> folder.</li>
                        <li>Refresh this page</li>
                        <li>Rejoice</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
