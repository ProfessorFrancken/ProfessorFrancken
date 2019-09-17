@if ($page == $paginator->currentPage())
    <li class="mx-2">
        <span class="py-2 px-3 bg-primary rounded text-white">
            {{ $page }}
        </span>
    </li>
@else
    <li class="mx-2">
        <a class="py-2 px-3 bg-white border-secondary border rounded" href="{{ $url }}">
            {{ $page }}
        </a>
    </li>
@endif
