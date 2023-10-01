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
                @isset($is_cover)
                @if($is_cover)
                    <i class="fas fa-star" title="This photo is used as the cover photo"></i>
                @endif
                @endisset

                @switch($photo->visibility)
                    @case('public')
                        <i class="fas fa-eye" title="Public visibility"></i>
                    @break
                    @case('private')
                        <i class="fas fa-eye-slash" title="Private visibility"></i>
                    @break
                    @case('members-only')
                        <i class="fas fa-user-friends" title="Members only visibility"></i>
                    @break
                @endswitch
            </span>
            @endif
    </div>
    </a>
</li>
