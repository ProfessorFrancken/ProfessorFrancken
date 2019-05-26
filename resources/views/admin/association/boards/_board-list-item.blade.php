<li class="p-3 mb-2">
    <div class="d-flex justify-content-between">
        <h3 class="section-header" >
            @if ($board->name != '')
                ‘{{ $board->name }}’
                <small class="ml-2">
                    {{ $board->board_year->toString() }}
                </small>
            @else
                {{ $board->board_year->toString() }}
            @endif
        </h3>

        <div>
            <a href="{{ action([\Francken\Association\Boards\Http\Controllers\AdminBoardsController::class, 'edit'], $board->id ?? 1) }}"
               class="btn btn-sm btn-outline-primary"
            >
                <i class="far fa-edit"></i>
                Edit
            </a>
        </div>
    </div>

    <div class="overflow-hidden bg-primary d-flex align-items-start rounded mt-2" style="height: 300px">
        <img
            src="{{ board_banner_image($board->photo, ['vertical-offset' => $board->photo_position]) }}"
            class="img-fluid h-100"
            style="object-fit: contain; max-height: 100%"
        >

        <ul class="p-3 list-unstyled d-flex flex-column justify-content-between h-100">
            @foreach($board->members as $member)
                <li class="d-flex align-items-center my-1">
                    @if (isset($member->photo))
                        <img
                            class="rounded-circle mr-3"
                            src="{{ image($member->photo, ['width' => 45, 'height' => 45]) }}"
                            alt="Photo of {{ $member->name }}"
                            style="width: 45px; height: 45px; object-fit: cover;"
                        >
                    @endif
                    <span class="text-white font-weight-bold mr-3">
                        {{ $member->name }}
                    </span>
                    <span class="text-white font-weight-light">
                        {{ $member->title }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</li>
