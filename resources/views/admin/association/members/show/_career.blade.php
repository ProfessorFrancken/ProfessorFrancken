<div class="card mb-3">
    <div class="card-body">
        <h4>Career</h4>

        @if($alumni->isNotEmpty())
            <ul>
                @foreach($alumni as $alumnus)
                    <li>
                        <strong>{{ $alumnus->partner->name  }}</strong>:
                        {{ $alumnus->position  }}
                        {{ $alumnus->started_position_at->format('F j Y')  }}
                        @if($alumnus->stopped_position_at)
                            until
                            {{ $alumnus->stopped_position_at->format('F j Y')  }}
                        @endif.
                    </li>
                @endforeach
            </ul>
        @else
            <div class="my-3 bg-light py-3 px-2">
                <p class="mb-0 text-center" style="font-size: 0.8rem">
                    {{ $member->fullname }}  hasn't been registered as an alumni for any of our partners.
                </p>
            </div>
        @endif
    </div>
</div>
