@isset ($breadcrumbs)
<nav aria-label="breadcrumb" class="container my-1 mt-md-5 px-0">
  <ol class="breadcrumb" style="background-color: #f2f5f8 !important;">
      @foreach ($breadcrumbs as $breadcrumb)
          @if (! $loop->last)
              <li class="breadcrumb-item">
                  <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['text'] }}</a>
              </li>
          @else
              <li class="breadcrumb-item active" aria-current="page">
                  {{ $breadcrumb['text'] }}
              </li>
          @endif
      @endforeach
  </ol>
</nav>
@endisset
