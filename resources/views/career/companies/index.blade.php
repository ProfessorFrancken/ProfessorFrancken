@extends('homepage.one-column-layout')

@section('content')
    <h1>Companies</h1>
<div class="row">
	@foreach ($companies as $company)
		@include('pages.career._company-summary', ['company' => $company])
	@endforeach
</div>
@endsection
