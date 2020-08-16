<li class="nav-item">
    <a
        class="{{ $class ?? '' }} font-weight-light nav-link py-3 px-4 {{ $request->category($select) ? 'border-left border-right bg-white' : '' }}"
        href="{{ action([\Francken\Treasurer\Http\Controllers\AdminProductsController::class, 'index'], ['category' => $select]) }}"
    >
        {!! $slot !!}
    </a>
</li>
