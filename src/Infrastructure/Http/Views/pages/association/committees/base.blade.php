@extends('pages.about')

@section('content')
        <div class="row">
            <div class="col-md-3">
                <h3>More committees</h3>
                <ul class="list-unstyled">
                    <li>Bincie (Dutch Field Trip Committee)</li>
                    <li>Borrelcie (Party Committee)</li>
                    <li>Brouwcie (Brewing Committee)</li>
                    <li>Buixie (Foreign Field Trip Committee)</li>
                    <li>Compucie (Computer Committee)</li>
                    <li>Parties</li>
                    <li>Fotocie (Photo Committee)</li>
                    <li>Francken Vrij Committee</li>
                </ul>
            </div>
            <div class="col-md-9">
                @yield('committee')
            </div>
        </div>


@endsection
