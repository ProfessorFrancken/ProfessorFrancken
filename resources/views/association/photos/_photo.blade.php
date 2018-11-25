<li
    class="d-flex align-items-center m-0 bg-white rounded photo
    {{ implode($classes ?? [])  }}
    {{  ($photo->is_tall) ? 'tall' : '' }}"
>
    <a href="{{ $href ?? '#' }}" class="w-100 h-100 photo-link">
        <img
            src="{{ $photo->flickr_base_url }}"
            srcset="{{ $photo->srcset() }}"
            class="w-100 h-100 rounded photo-img"
        >
    </a>
    <div class="d-flex flex-column rounded text-white p-3 w-100 photo-overlay">
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
</li>
