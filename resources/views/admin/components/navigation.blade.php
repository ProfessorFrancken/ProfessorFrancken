<nav class="styled-navigation francken-navigation">
    <ul class="navigation-items list-unstyled text-left d-md-flex flex-column mb-0 pb-2 text-muted bg-primary list-unstyled w-100">
        @foreach ($menu as $item)
            <x-admin-navigation-group :item="$item" />
        @endforeach
    </ul>
</nav>
