@extends('homepage.two-column-layout')

@section('content')
  <h1 class="section-header">Jobs and internships</h1>

  <p>
      Are you looking for a job or an internship?
  </p>

  @if (count($jobs) > 0)
      @foreach($jobs as $job)
          @include('pages.career._job-openings-of-company', ['job' => $job])
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
                    {!! Form::text('job-title', null, ['placeholder' => 'Search by job title', 'class' => 'form-control'])  !!}
                </div>

                <div class="form-group">
                    {!!
                       Form::select(
                           'company',
                           array_merge(
                               ['' => 'Any'],
                               array_combine($companies, $companies)
                           ),
                           null,
                           ['class' => 'form-control']
                       )
                    !!}
                </div>

                <div class="form-group row">
                    <label class="col-5 col-form-label" for="size">Sector</label>
                    <div class="col-7">
                        {!!
                           Form::select(
                               'sector',
                               array_merge(
                                   ['' => 'Any'],
                                   array_combine(array_keys($sectors), array_keys($sectors))
                               ),
                               null,
                               ['class' => 'form-control']
                           )
                        !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-5 col-form-label" for="size">Type of job</label>
                    <div class="col-7">
                        {!!
                           Form::select(
                               'jobType',
                               array_merge(
                                   ['' => 'Any'],
                                   array_combine(array_keys($types), array_keys($types))
                               ),
                               null,
                               ['class' => 'form-control']
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
