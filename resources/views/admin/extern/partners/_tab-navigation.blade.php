<li class="nav-item">
    <a
        class="{{ $class ?? '' }} font-weight-light nav-link py-3 px-4 {{ $request->selected($select) ? 'border-left border-right bg-white' : '' }}"
        href="{{ action([\Francken\Extern\Http\AdminPartnersController::class, 'index'], ['select' => $select]) }}"
    >
        {!! $slot !!}
    </a>
</li>
