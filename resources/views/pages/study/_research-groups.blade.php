<div class="section-header d-inline-block mt-4 h1">{{  $group['title']}}</div>
<div class="row mt-2">

	<div class="col text-justify " >
		
		{!!  $group['description'] !!}
	</div>
	<!--<div class="col">
		<img src="http://www.rug.nl{{ $group['photo'] }}" width="450" height="225" class="rounded"> 
	</div>-->
</div>
<br>
<div class="row">
	@foreach($group['groups'] as $unit)
		<div class="col-md-6 mt-3">
			<img src="http://www.rug.nl{{ $unit['foto'] }}" width="283" height="142" class="rounded"> 
			<h2>Prof. {{ $unit['group'] }}</h2>
			{{ $unit['title'] }}
			<br>
			<a class="btn btn-secondary" href="{{ $unit['contact'] }}">
				Contact
			</a>
			<a class="btn btn-info" href="{{ $unit['link'] }}">
				Group Info
			</a>
		</div>
	@endforeach
</div>
<br><br><br>
