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
>
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
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
 $(document).ready(function () {
     var membersSource = {!! json_encode($members) !!};

     $('#{{ $name }}').autocomplete({
         source: membersSource,
         select: function (event, ui) {
             $('#{{ $nameId }}').val(ui.item.id);
         },
         minLength: 2
     });
 });
</script>
@endpush
