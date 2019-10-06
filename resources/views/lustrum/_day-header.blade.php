<li class="my-5 bg-white rounded shadow-sm p-3">
  <h1 class="d-flex justify-content-between align-items-end pb-2 mb-4 border-bottom">
    {{ $activity }} - {{ $day }}
    <small class="h4">{{ $ocean }}</small>
  </h1>

  {{ $slot }}
</li>
