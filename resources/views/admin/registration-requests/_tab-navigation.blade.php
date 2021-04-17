<li class="nav-item">
    <a
        class="{{ $class ?? '' }} font-weight-light nav-link py-3 px-4 {{ $request->selected($select) ? 'border-left border-right bg-white' : '' }}"
        href="{{ action([\Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController::class, 'index'], $request->searchQueryKeys($select)) }}"
    >
        {!! $slot !!}
    </a>
</li>
