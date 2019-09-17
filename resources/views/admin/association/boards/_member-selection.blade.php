<div class="form-group">
    <label for="{$name}">Member</label>
    {!!
       Form::text(
           "{$name}[member]",
           $member_name ?? null,
           [
               'class' => "form-control member-selection",
               'placeholder' => '',
               'id' => "{$name}",
               'data-target' => "{$name}[member_id]"
           ]
       )
    !!}
    {!!
       Form::hidden(
           "{$name}[member_id]",
           $id ?? null,
           ['id' => "{$name}[member_id]"]
       )
    !!}
</div>
