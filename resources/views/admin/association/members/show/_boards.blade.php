@foreach($boardMembers as $boardMember)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-start">
                <div style="max-height: 7em; width: 7em" class="mr-3">
                    <img src="{{  $boardMember->photo}}" class="img-fluid" style="max-height: 100%;" />
                </div>

                <div class="flex-grow-1">
                    <div  class="d-flex justify-content-between align-items-start">
                        <h4>
                            {{ $boardMember->board->board_name->toString() }}
                        </h4>
                        <small>{{ $boardMember->board->board_year->toString()  }}</small>
                    </div>
                    <h6>{{ $boardMember->title  }}</h6>
                </div>
            </div>
        </div>
    </div>
@endforeach
