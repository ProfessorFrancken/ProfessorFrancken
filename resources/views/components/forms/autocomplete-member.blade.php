<div class="form-group">
    @if ($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    {!!
       Form::text(
           $name,
           $value,
           [
               'class' => 'form-control member' . ($errors->has($nameId) ? ' is-invalid' : ''),
               'placeholder' => $placeholder,
               'id' => $name
           ]
       )
    !!}
    {!!
       Form::hidden($nameId, $valueId, ['id' => $nameId])
    !!}

    <x-forms.error :name="$nameId" />
    <x-forms.error :name="$name" />
</div>

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<style type="text/css" media="screen">
     .ui-autocomplete, .ui-front, .ui-menu, .ui-widget, .ui-widget-content, .ui-corner-all {
         z-index: 1000;
     }
</style>
@endpush

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<style type="text/css" media="screen">
     .ui-autocomplete, .ui-front, .ui-menu, .ui-widget, .ui-widget-content, .ui-corner-all {
         z-index: 1000;
     }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.5/awesomplete.min.js" integrity="sha512-HcBl0GSJvt4Qecm4srHapirUx0HJDi2zYXm6KUKNNUGdTIN9cBwakVZHWmRVj4MKgy1AChqhWGYcMDbRKgO0zg==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.5/awesomplete.base.css" integrity="sha512-JreNkqx4723Zhvmy8TtRDue2ZbPrPIzJSjK84o3KUsjA/eKuOW3bhea06M8urMlsFS3Yj+9m3OudzqJDrk3yOQ==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.5/awesomplete.theme.min.css" integrity="sha512-NhTirzJR+yVbYUI+kkm99Bp3ORG0yv5Kd46kBcmGowLMBE0vX25h7GsJFVrMNGkqcJqr5lYRMfDk/cCwLKzCYA==" crossorigin="anonymous" />
<style type="text/css" media="">
    div.awesomplete {
        display: block;
    }
    .awesomplete>ul {
        border-radius: .3em;
        margin: .2em 0 0;
        background: hsla(0,0%,100%,1.0);
        background: linear-gradient(to bottom right,#fff,hsla(0,0%,100%,.9));
        color: #001744 !important;
        border: 1px solid rgba(0,0,0,.3);
        box-shadow: 0.05em 0.2em 0.6em rgba(0,0,0,.2);
        text-shadow: none;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        var membersSource = {!! json_encode($members) !!};
        var input = document.getElementById("{{ $name }}");
        new Awesomplete(input, {
            minChars: 2,
            list: membersSource,
            // insert label instead of value into the input.
            replace: function(suggestion) {
                this.input.value = suggestion.label;
                var idInput = document.getElementById("{{ $nameId }}");
                idInput.value = suggestion.value;
            }
        });
    });
</script>
@endpush
