@extends('layout.two-column-layout')
@section('header-image-url', '/images/header/oslo.jpg')
@section('title', "Job openings and internships - T.F.V. 'Professor Francken'")
@section('description', "Find job openings and internships related to engineering physics.")

@section('content')
  <h1 class="section-header">Jobs and internships</h1>

  <p>
      Are you looking for a job or an internship?
  </p>

  @if ($vacancies->isNotEmpty())
      @foreach($vacancies as $vacancy)
          <section class="job-opening">
              <img
                  class="pull-right img-fluid job-opening__company-logo job-opening__company-logo "
                  style="max-width: 100px;"
                  alt="{{ $vacancy->title }}"
                  src="{{ $vacancy->partner->logo }}"
              />

              <h3 class="h4 job-opening__title">
                  {{ $vacancy->title }}
              </h3>

              <ul class="list-inline">
                  <li class="list-inline-item">
                      <a href="{{ $vacancy->vacancy_url }}" class="text-muted">
                          <i class="fa fa-globe" aria-hidden="true"></i>
                          {{ $vacancy->title }}
                      </a>
                  </li>
                  <li class="list-inline-item">
                      <a href="{{ route('job-openings', array_merge(request()->all(), ['sector_id' => $vacancy->sector_id])) }}">
                          <i class="fa fa-{{ $vacancy->sector->icon }}" aria-hidden="true"></i> {{ $vacancy->sector->name }}
                      </a>
                  </li>
                  <li class="list-inline-item">
                      <a href="{{ route('job-openings', array_merge(request()->all(), ['job_type' => $vacancy->type])) }}">
                          <i class="fa fa-{{ $types[$vacancy->type] }}" aria-hidden="true"></i> {{ $vacancy->type }}
                      </a>
                  </li>
              </ul>

              <p>
                  {{ $vacancy->description ?? '' }}
              </p>

              <p>
                  <a class="" href="{{ $vacancy->vacancy_url }}">
                      Show details
                  </a>
              </p>
          </section>
      @endforeach
  @else
      <p>
          We could not find any job openings
      </p>
  @endif
@endsection

@section('aside')
<div class="agenda">
    <h3 class="section-header agenda-header">
        <label for="search-news">
            Search for job openings
        </label>
    </h3>
    <form action="{{ url('/career/job-openings') }}" method="GET" class="form-horizontal">
        <x-forms.text name="title" label="Title" placeholder="Search by job title" :value="$request->title()" />
        <x-forms.select name='partner_id' label="Company" :value="$request->partnerId()" :options="$partners" />
        <x-forms.select name='sector_id' label="Sector" :value="$request->sectorId()" :options="$sectors" />
        <x-forms.select
            name='job_type'
            label="Type of job"
            :value="$request->jobType()"
            :options="array_merge(['' => 'Any'], array_combine(array_keys($types), array_keys($types)))"
        />

        <button type="submit" class="btn btn-block btn-primary">Apply filters</button>
    </form>
</div>
@endsection
