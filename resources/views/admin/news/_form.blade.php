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

        <div class="row d-flex align-items-stretch">
            <div class="col">
                {!! Form::textarea('content', $news->source_contents, ['class' => 'form-control', 'id' => 'news-item-content']) !!}
            </div>
            <div class="col-md-6 d-none">
                <div style="overflow-y: scroll" class="card">
                    <div class="card-body" id="news-item-preview">

                        {!! $news->compiled_contents !!}
                    </div>
                </div>
            </div>
        </div>

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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

{{-- Syntax highlighting --}}
<script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">


<script>
 var simplemde = new SimpleMDE({
     element: document.getElementById("news-item-content"),
     spellChecker: false,
     autoSave: {
         enabled: true,
         uniqueId: "news-{{ $news->id  }}"
     },
     promptURLs: true,
     /* previewRender: ,*/
     /* previewRender: function(plainText) {*/
     /* console.log(plainText);*/
         /* return customMarkdownParser(plainText); // Returns HTML from a custom parser*/
       /* },*/
       previewRender: function(plainText) { // Async method
         var that = this;
         var parent = that.parent;

         var preview = document.getElementById("news-item-preview");
         var compiled = this.parent.markdown(plainText);
         preview.innerHTML = compiled;
         return compiled;
       },

     toolbar: [
         "bold", "italic", "strikethrough",
         "|",
         "heading-1", "heading-2", "heading-3",
         "|",
         "code", "quote", "link", "image", "table",
         "|",
         "unordered-list", "ordered-list",
         "|",
         "preview", "side-by-side", "fullscreen",
         "guide"
     ]
 });
</script>
<style type="text/css">
 .CodeMirror, .CodeMirror-scroll {
     max-height: 300px;
 }
</style>

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
