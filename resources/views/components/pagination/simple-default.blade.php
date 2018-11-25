@if ($paginator->hasPages())
    <ul class="my-4 list-unstyled d-flex justify-content-between" role="navigation">
        <div class="d-flex">
            @if ($paginator->onFirstPage())
                <li class="mr-2">
                    <span aria-disabled="true"
                        aria-label="@lang('pagination.previous')"
                        class="py-2 px-3 bg-white border-secondary border rounded">
@lang('pagination.previous')
                    </span>
                </li>
            @else
                <li class="mr-2">
                    <a href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        aria-label="@lang('pagination.previous')"
                        class="py-2 px-3 bg-white border-secondary border rounded">
@lang('pagination.previous')
                    </a>
                </li>
            @endif
        </div>



        <div class="d-flex">
            @if ($paginator->hasMorePages())
                <li class="ml-2">
                    <a href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                        aria-label="@lang('pagination.next')"
                        class="py-2 px-3 bg-white border-secondary border rounded"
                    >
@lang('pagination.next')
                    </a>
                </li>
            @else
                <li class="ml-2">
                    <span aria-disabled="true"
                        aria-label="@lang('pagination.next')"
                        class="py-2 px-3 bg-white border-secondary border rounded"
                    >
@lang('pagination.next')
                    </span>
                </li>
            @endif
        </div>
    </ul>
@endif
