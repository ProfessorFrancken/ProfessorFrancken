<h4 class="font-weight-bold">
    Sign up settings
</h4>

<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="deadline_at">Sign up deadline</label>
            {!!
                   Form::datetime(
                       'deadline_at',
                       optional($activity->start_date)->format('Y-m-d H:i:s'),
                       ['class' =>'form-control', 'id' => 'deadline_at'],
                   )
            !!}
            <small class="form-text text-muted">
                After this deadline only board members can sign up members
            </small>
        </div>
        <div class="form-group">
            <label for="max_sign_ups">Max sign ups</label>
            {!!
                   Form::number(
                       'max_sign_ups',
                       null,
                       ['class' => 'form-control', 'id' => 'max_plus_ones_per_member']
                   )
            !!}
            <small class="form-text text-muted">
                Set this field so that members can no longer sign up via our website if the maximum number of sign ups has been met.
                New attendees can still be signed up by a board member if this limit was met.
            </small>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="costs_per_person">Costs per person</label>
            {!!
                   Form::number(
                       'costs_per_person',
                       null,
                       ['class' => 'form-control', 'id' => 'costs_per_person']
                   )
            !!}
            <small class="form-text text-muted">
                Costs per person in cents (i.e. if the costs are &euro;5,-, fill in 500)
            </small>
        </div>
        <div class="form-group">
            <label for="costs_per_person">Max plus ones per member</label>
            {!!
                   Form::number(
                       'max_plus_ones_per_member',
                       null,
                       ['class' => 'form-control', 'id' => 'max_plus_ones_per_member']
                   )
            !!}
        </div>

        <div class="form-group form-check">
            {!!
                   Form::checkbox(
                       'ask_for_dietary_wishes',
                       true,
                       null,
                       ['class' => 'form-check-input', 'id' => 'ask_for_dietary_wishes']
                   )
            !!}
            <label class="form-check-label" for="ask_for_dietary_wishes">
                Show a form field for dietary wishes when members sign up
            </label>
        </div>

        <div class="form-group form-check">
            {!!
                   Form::checkbox(
                       'ask_for_drivers_license',
                       true,
                       null,
                       ['class' => 'form-check-input', 'id' => 'ask_for_drivers_license']
                   )
            !!}
            <label class="form-check-label" for="ask_for_drivers_license">
                Ask members if they have a drivers license
            </label>
        </div>
    </div>
</div>
