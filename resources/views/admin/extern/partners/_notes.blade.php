<div class="card">
    <div class="card-body">
        <h4 class="font-weight-bold">
            <i class="fas fa-sticky-note"></i>
            Extern notes
        </h4>

        <ul class='list-unstyled'>
            @forelse ($partner->notes as $note)
                <li class="d-flex flex-column my-3 {{ $loop->last ? '' : 'border-bottom py-3' }}">
                    <small class="text-muted">
                        On {{ $note->created_at->format('Y-m-d') }}, {{ $note->member->fullname }} wrote:
                    </small>
                    <p class="bg-light p-3 my-1" style="white-space: pre-line;">{!!  $note->note !!}</p>
                </li>
            @empty
                <li class="d-flex flex-column my-3">
                    Use these notes to keep to keep track of arrangements with a partner or any other information that might be useful for you or your future kandi.
                </li>
            @endforelse
        </ul>
    </div>
    <div class="card-footer">
        {!!
           Form::model($partner, [
               'url' => action(
                   [\Francken\Extern\Http\AdminPartnerNotesController::class, 'store'],
                   ['partner' => $partner]
               ),
               'method' => 'POST',
           ])
        !!}

        <x-forms.textarea name="note" rows="3" />

        <button class='btn btn-text btn-sm'>
            <i class="fas fa-check"></i>
            Save note
        </button>
        {!! Form::close() !!}
    </div>
</div>
