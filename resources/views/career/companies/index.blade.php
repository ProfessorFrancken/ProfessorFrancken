@extends('homepage.one-column-layout')

@section('content')
    <h1 class="section-header section-header--centered">Companies</h1>

    <div class="row">
	      @foreach ($companies as $company)
		        @include('pages.career._company-summary', ['company' => $company])
	      @endforeach
    </div>
@endsection
