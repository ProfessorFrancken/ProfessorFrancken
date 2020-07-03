<h5 class="font-weight-bold">
    <i class="fas fa-user-plus"></i>
    Install committee member
</h5>

{!!
   Form::model(
       $committee,
       [
           'url' => action(
               [\Francken\Association\Committees\Http\AdminCommitteeMembersController::class, 'store'],
               ['committee' => $committee, 'board' => $committee->board]
           ),
           'method' => 'post'
       ]
   )
!!}
    @include('admin.association.committees.members._form', ['committee' => $committee, 'members' => $members])

{{--
    <div class="form-group form-check mt-3 mb-4">
        <input type="checkbox" class="form-check-input" id="email_notification">
        <label class="form-check-label" for="email_notification">Send email notification</label>
        <small class="form-text text-muted">
            We will send the member an email notification informing them that they've been installed to the {{ $committee->name }} committee.
        </small>
    </div>
--}}
    <button class="btn btn-outline-primary">
        <i class="fas fa-plus"></i>
        Install committee member
    </button>
{!! Form::close() !!}
