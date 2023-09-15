<li
    class="d-flex align-items-center m-0 bg-white rounded photo
    {{ implode($classes ?? [])  }}
    {{  ($photo->is_tall) ? 'tall' : '' }}"
>
    <a href="{{ $href ?? '#' }}" class="w-100 h-100 photo-link">
        <img
            src="{{ $photo->src() }}"
            class="w-100 h-100 rounded photo-img"
        >
    </a>
    <div class="d-flex justify-content-between rounded text-white p-3 w-100 photo-overlay">
        <div class="d-flex flex-column">
        <div>
            @isset($views)
            <span>
                <strong>
                    {{ $views }}
                </strong>
                views
            </span>
            @endisset
            @isset($amount_of_photos)
            <span>
                <strong>
                    {{ $amount_of_photos }}
                </strong>
                photos
            </span>
            @endisset
        </div>
        @isset($title)
        <strong>
            {{ $title }}
        </strong>
        @endisset
        </div>
            @if(isset($show_visibility) && $show_visibility)
            <span class="float-right">
                @switch($photo->visibility)
                    @case('public')
                        <i class="fas fa-eye"></i>
                    @break
                    @case('private')
                        <i class="fas fa-eye-slash"></i>
                    @break
                    @case('members-only')
                        <i class="fas fa-user-friends"></i>
                    @break
                @endswitch
            </span>
            @endif
    </div>
</li>
