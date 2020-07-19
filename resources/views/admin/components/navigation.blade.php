<nav class="styled-navigation francken-navigation">
    <ul class="navigation-items list-unstyled text-left d-md-flex flex-column mb-0 pb-2 text-muted bg-primary list-unstyled w-100">
        @foreach ($menu as $item)
            <li class="pb-4">
                <span class="d-block font-weight-bold text-white h5 mb-0 p-3 bg-dark-primary">
                    {{ $item['name'] }}
                </span>

                <ul class="list-unstyled">
                    @foreach ($item['items'] as $subItem)
                        <?php $active = Request::segment(3) == $subItem['url'] ? 'active' : ''; ?>
                        @can($subItem['can'] ?? 'can-access-dashboard')
                        @if ($subItem['works'] || Auth::user()->can('super-admin-read'))
                            <li class="{{ $active }} text-white">
                                <a  href="/admin/{{ $item['url'] }}/{{ $subItem['url'] }}" class="d-block px-3 py-2 admin-navigation-item d-flex justify-content-between align-items-center">
                                    <span>
                                        @if (! $subItem['works'])
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        @endif

                                        {{ $subItem['name'] }}
                                    </span>

                                    <span class="badge badge-light d-none">3</span>
                                </a>
                            </li>
                        @endif
                        @endcan
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</nav>
