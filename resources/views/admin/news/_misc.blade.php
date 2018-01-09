<div class="card">
    <div class="card-body">
        <h3>Miscelanious</h3>


        <div class="form-group row">
            <div class="col-sm-4">
                <i class="fa fa-link" aria-hidden="true"></i>
                {!! Form::label('link', 'Link slug:', ['class' => 'form-control-label']) !!}

            </div>
            <div class="col-sm-8">
                {!! Form::text('link', $news->link(), ['class' => 'form-control', 'disabled' => true]) !!}
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-4">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                {!! Form::label('latest-edit', 'Latest edit at:', ['class' => 'control-label-col']) !!}
            </div>
            <div class="col-sm-8">
                {!! Form::date('publicationDate', $news->publicationDate()->format('Y-m-d'), ['class' => 'form-control', 'disabled' => true]) !!}
            </div>
        </div>

        <a class="card-link" href="/association/news/{{ $news->link() }}">
            View {{ $news->title() }}
        </a>
    </div>
</div>
