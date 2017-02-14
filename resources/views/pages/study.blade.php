@extends('homepage.one-column-layout')

@section('content')

  <h1>Study</h1>

  <p>T.F.V. ‘Professor Francken’ organiseert verschillende studiegerelateerde activiteiten zoals symposia, vakgroepexcursies en oefenmiddagen voor tentamens. Daarnaast hebben we regelmatig contact met besturende organen als opleidingscommissies, de faculteitsraad en het opleidingsbestuur.</p>

  <hr>

  <div class="row">
    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Study help</h2>
      <p>Oude tentamens en aantekeningen van hoorcolleges.</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Vakgroepen</h2>
      <p>Informatie over de vakgroepen technische natuurkunde.</p>
    </div>

    <div style="text-align: center" class="col-md-4">
      <div style="height: 150px; width: 150px; border-radius: 50%; background-color: grey; margin: auto"></div>
      <h2>Honours</h2>
      <p>Informatie over het honours college.</p>
    </div>

  </div>

@endsection

@section('header-image')
    @component('homepage.header._header_image')
    @slot('headerImageClass')
        header__registration-cta--small header__registration-cta--study
    @endslot

    @endcomponent
@endsection
