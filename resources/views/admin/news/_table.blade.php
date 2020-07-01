@if ($news->isNotEmpty())
    <table class="table table-hover table-small">
        <thead>
            <tr>
                <th>Publication date</th>
                <th>Title</th>
                <th colspan="1" class="text-right">Actions</th>
            </tr>
        </thead>
        @foreach ($news as $item)
            <tr>
                <td>
                    @if ($item->published_at)
                        <small class="text-muted">
                            {{ $item->published_at->format('d M Y')}}
                        </small>
                    @endif
                </td>
                <td>
                    {{ $item->title }}
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-primary btn-sm mr-2" href="{{ action([\Francken\Association\News\Http\AdminNewsController::class, 'preview'], ['news' => $item]) }}">
                        <i class="fa fa-eye mr-1" aria-hidden="true"></i>
                        Show preview
                    </a>
                    <a class="btn btn-outline-primary btn-sm" href="{{ action([\Francken\Association\News\Http\AdminNewsController::class, 'show'], ['news' => $item]) }}">
                        <i class="fa fa-edit mr-1" aria-hidden="true"></i>
                        Edit
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endif
