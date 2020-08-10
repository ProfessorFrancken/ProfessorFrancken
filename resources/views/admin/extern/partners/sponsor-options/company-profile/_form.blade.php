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

<x-forms.markdown />
