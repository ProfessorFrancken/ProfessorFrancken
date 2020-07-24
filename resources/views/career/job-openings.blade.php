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
                  src="{{ image($vacancy->partner->logo, ['width' => 100, 'height' => 100, 'crop' => 0]) }}"
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
    <ul class="agenda-list list-unstyled">
        <li class="agenda-item" style="margin-bottom: .5em; padding-bottom: .5em;">
            <form action="{{ url('/career/job-openings') }}" method="GET" class="form-horizontal">

                <div class="form-group">
                    {!! Form::text('title', $request->title(), ['placeholder' => 'Search by job title', 'class' => 'form-control'])  !!}
                </div>

                <div class="form-group">
                    {!!
                       Form::select(
                           'partner_id',
                           $partners,
                           $request->partnerId(),
                           ['class' => 'form-control']
                       )
                    !!}
                </div>

                <div class="form-group row">
                    <label class="col-5 col-form-label" for="sector_id">Sector</label>
                    <div class="col-7">
                        {!!
                           Form::select(
                               'sector_id',
                               $sectors,
                               $request->sectorId(),
                               ['class' =>'form-control', 'id' => 'sector_id']
                           )
                        !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-5 col-form-label" for="job_type">Type of job</label>
                    <div class="col-7">
                        {!!
                           Form::select(
                               'job_type',
                               array_merge(
                                   ['' => 'Any'],
                                   array_combine(array_keys($types), array_keys($types))
                               ),
                               $request->jobType(),
                               ['class' => 'form-control', 'id' => 'job_type']
                           )
                        !!}
                    </div>
                </div>

                <button type="submit" class="btn btn-block btn-primary">Apply filters</button>
            </form>
        </li>
    </ul>
</div>
@endsection
