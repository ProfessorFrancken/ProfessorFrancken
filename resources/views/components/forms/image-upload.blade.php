@props([
    'name' => 'photo',
    'label' => 'Photo',
    'outputImageId' => 'photo-image',
    'help' => '',
])

<x-forms.form-group :name="$name" :help="$help">
    <x-slot name="label">
        <button class="btn btn-block btn-sm btn-primary mb-0">
            <i class="fas fa-upload"></i>
            {{ $label }}
        </button>
    </x-slot>

    {!!
           Form::file(
               $name,
               [
                   'class' => 'sr-only form-control-file' . ($errors->has($name) ? ' is-invalid' : ''),
                   'id' => $name
               ]
           )
    !!}
</x-forms.form-group>

@push('scripts')
<script>
    (function() {
        // Change the source of the output image to the uploaded file
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('{{ $outputImageId }}');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
        var uploadImage = document.getElementById('{{ $name }}');
        uploadImage.addEventListener('change', loadFile);

        // Open upload screen when clicking on the output image
        var outputImage = document.getElementById('{{ $outputImageId }}');
        outputImage.addEventListener('click', function() {
            uploadImage.click();
        });
    })()
</script>
@endpush
