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

    @error($nameId)
    <p class="invalid-feedback">
        {{ $message  }}
    </p>
    @enderror
    @error($name)
    <p class="invalid-feedback">
        {{ $message  }}
    </p>
    @enderror
</div>

@push('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
@endpush

@push('scripts')
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
 $(document).ready(function () {
     var members = {!! json_encode($members) !!};
     var membersSource = members.map(function (member) {
         return {
             label: [member.voornaam, member.tussenvoegsel, member.achternaam].filter(function (val) { return val }).join(' '),
             id: member.id
         };
     });

     $('#{{ $name }}').autocomplete({
         source: membersSource,
         select: function (event, ui) {
             console.log($('#{{ $nameId }}'));
             $('#{{ $nameId }}').val(ui.item.id);
         },
         minLength: 2
     });
 });
</script>
@endpush
