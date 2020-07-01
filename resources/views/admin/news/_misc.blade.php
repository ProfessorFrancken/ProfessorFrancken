<div class="card">
    <div class="card-body">
        <h3>Miscelanious</h3>

        <div class="form-group row">
            <div class="col-sm-4">
                <i class="fa fa-link" aria-hidden="true"></i>
                {!! Form::label('link', 'Link slug:', ['class' => 'form-control-label']) !!}

            </div>
            <div class="col-sm-8">
                {!! Form::text('link', $news->slug, ['class' => 'form-control', 'disabled' => true]) !!}
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-4">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                {!! Form::label('latest-edit', 'Latest edit at:', ['class' => 'control-label-col']) !!}
            </div>
            <div class="col-sm-8">
                {!! Form::date('publicationDate', optional($news->published_at)->format('Y-m-d'), ['class' => 'form-control', 'disabled' => true]) !!}
            </div>
        </div>

        <a class="card-link" href="{{ action([\Francken\Association\News\Http\AdminNewsController::class, 'preview'], ['news' => $news]) }}">
            View {{ $news->title }}
        </a>
    </div>
</div>
