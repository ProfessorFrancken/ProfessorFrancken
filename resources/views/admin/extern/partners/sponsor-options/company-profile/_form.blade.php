<div class="form-group">
    <label for="display_name">Display name</label>
    {!!
       Form::text(
           'display_name',
           $profile->display_name,
           ['class' => 'form-control', 'id' => 'diplay_name']
       )
    !!}
    <p class="form-text text-muted">
        Set a custom display name if this partner has a name such as "Thales Nederland B.V." and you'd rather show "Thales" when the partner is viewed on the website.
    </p>
</div>
<div class="form-group form-check">
    {!!
       Form::checkbox(
           'is_enabled',
           true,
           $profile->is_enabled,
           ['class' => 'form-check-input', 'id' => 'is_enabled']
       )
    !!}
    <label class="form-check-label" for="is_enabled">Show on website</label>
</div>

<div class="row d-flex align-items-stretch">
    <div class="col">
        <div class="form-group">
            <label for="source_content">Content</label>
            {!!
               Form::textarea(
                   'source_content',
                   null,
                   ['class' => 'form-control', 'id' => 'source_content']
               )
            !!}
            <small class="form-text text-muted">
                Use <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">
                Markdown</a> to format the company profile.
            </small>
        </div>
    </div>
    <div class="col-md-6 d-none">
        <div style="overflow-y: scroll" class="card">
            <div class="card-body" id="preview">
                {!! $profile->compiled_content !!}
            </div>
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
     element: document.getElementById("source_content"),
     spellChecker: false,
     promptURLs: true,
     /* previewRender: ,*/
     /* previewRender: function(plainText) {*/
     /* console.log(plainText);*/
         /* return customMarkdownParser(plainText); // Returns HTML from a custom parser*/
       /* },*/
       previewRender: function(plainText) { // Async method
         var that = this;
         var parent = that.parent;

         var preview = document.getElementById("preview");
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
@endpush
