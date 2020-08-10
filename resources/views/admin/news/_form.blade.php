<div class="card">
    <div class="card-body">
        <h3 class="card-title">
            Title
        </h3>

        <div class="form-group mt-3">
            {!! Form::text('title', $news->title, ['class' => 'form-control']) !!}
        </div>

        <h3 class="card-title">
            Content
        </h3>

        <x-forms.markdown />

        <h4 class="card-title my-3">
            Exerpt
        </h4>

        <div class="form-group mt-3">
            {!! Form::textarea('exerpt', $news->exerpt, ['class' => 'form-control', 'rows' => 3]) !!}

            <span class="form-help">
                Note try to keep the exerpt short and make it either a nice summary or a short introduction to the news post. Don't use any Markdown formatting.
            </span>
        </div>
    </div>
    <div class="card-body">
        @if (! is_null($news->published_at) && $news->published_at < (new DateTimeImmutable('2017-08-24')))
            <div class="alert alert-warning">

                <strong>
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    Warning!
                </strong>
                This news item was imported from our old wordpress website.
                By changing its content you might break stuff..
            </div>
        @endif

        <div class="d-flex justify-content-between">
            @if (is_null($news->published_at) || $news->published_at > (new DateTimeImmutable('2017-08-24')))
                <button type="submit" class="btn btn-outline-success">
                    <i class="fa fa-check" aria-hidden="true"></i>

                    {{ $action }}
                </button>
            @else
                <button type="submit" class="btn btn-outline-warning" onclick="return confirm('Saving this news item might override import setting. Are you sure you want to save?')">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>

                    {{ $action }}
                </button>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
 function confirmSavingOfImportedScript(e) {
     if (confirm('Saving this news item might override import setting')) {
         return true;
     }
     e.preventDefault();
     e.stopPropogation();
     return false;
 }
</script>
@endpush
