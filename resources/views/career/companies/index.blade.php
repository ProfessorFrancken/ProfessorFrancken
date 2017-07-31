@extends('layout.one-column-layout')
@section('header-image-url', '/images/header/oslo.jpg')
@section('title', "Company profiles - T.F.V. 'Professor Francken'")
@section('keywords', implode(', ', array_map(function ($company) { return $company['name']; }, $companies)))

@section('content')
    <h1 class="section-header section-header--centered">Companies</h1>

    <div class="row">
	      @foreach ($companies as $company)
		        @include('career.companies._summary', ['company' => $company])
	      @endforeach
    </div>
@endsection
