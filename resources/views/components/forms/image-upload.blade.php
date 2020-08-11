@props([
    'name' => 'photo',
    'label' => 'Photo',
    'outputImageId' => 'photo-image',
    'help' => '',
])

<div class="form-group">
    <label for="{{ $name }}" class="btn btn-block btn-sm btn-primary mb-0">
        <i class="fas fa-upload"></i>
        {{ $label }}
    </label>
    {!!
           Form::file(
               $name,
               [
                   'class' => 'sr-only form-control-file' . ($errors->has($name) ? ' is-invalid' : ''),
                   'id' => $name
               ]
           )
    !!}

    @error($name)
    <p class="invalid-feedback">
        {{ $message  }}
    </p>
    @enderror

    {!! $help !!}
</div>

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
