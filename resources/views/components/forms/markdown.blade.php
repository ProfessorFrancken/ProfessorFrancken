@props([
    'label' => 'Content',
    'name' => 'source_content',
    'value' => null,
    'required' => false,
    'disabled' => false,
])

<x-forms.form-group :name="$name" :label="$label">
    {!!
           Form::textarea(
               $name,
               $value,
               [
                   'class' => 'form-control',
                   'id' => $name,
                   'required' => $required,
                   'disabled' => $disabled,
               ]
           )
    !!}

    <x-slot name="help">
        Use <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">
        Markdown</a> to format this text.
    </x-slot>
</x-forms.form-group>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

{{-- Syntax highlighting --}}
<script src="https://cdn.jsdelivr.net/highlight.js/latest/highlight.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/highlight.js/latest/styles/github.min.css">

<style>
.editor-toolbar .table {
    width: auto;
}
</style>

<script>
    var simplemde = new EasyMDE({
        element: document.getElementById("{{ $name }}"),
        autosave: {
            enabled: true,
            // Try to make a unique id based on the input's name and the current page's url
            uniqueId: "francken-{{ $name }}-{{ \Illuminate\Support\Str::slug(url()->current()) }}"
        },
        spellChecker: false,
        promptURLs: true,
        toolbar: [
            "bold", "italic", "strikethrough",
            "|",
            "heading-1", "heading-2", "heading-3",
            "|",
            "code", "quote", "link", "image", "table",
            "|",
            "unordered-list", "ordered-list",
            "|",
            "preview",
            "guide"
        ],
        status: false,
        maxHeight: "600px"
    });
</script>
@endpush
