<div class="card">
    <div class="card-body">

        <x-forms.text name="title" label="Title" :value="$news->title" />
        <x-forms.markdown name="content" label="Content" :value="$news->source_contents" />
        <x-forms.textarea name="exerpt" label="Exerpt" :value="$news->exerpt">
            <x-slot name="help">
                Note try to keep the exerpt short and make it either a nice summary or a short introduction to the news post. Don't use any Markdown formatting.
            </x-slot>
        </x-forms.textarea>
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
