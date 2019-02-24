@if (count($news) > 0)
    <table class="table table-hover table-small">
        <thead>
            <tr>
                <th>Date</th>
                <th>Title</th>
                <th colspan="1" class="text-right">Actions</th>
            </tr>
        </thead>
        @foreach ($news as $item)
            <tr>
                <td>
                    <small class="text-muted">
                        {{ $item->publicationDate()->format('d M Y')}}
                    </small>
                </td>
                <td>
                    {{ $item->title() }}
                </td>
                <td class="text-right">
                    <a class="btn btn-outline-primary btn-sm mr-2" href="{{ $item->url() }}">
                        <i class="fa fa-eye mr-1" aria-hidden="true"></i>
                        View
                    </a>
                    <a class="btn btn-outline-primary btn-sm" href="/admin/association/news/{{ $item->id() }}">
                        <i class="fa fa-edit mr-1" aria-hidden="true"></i>
                        Edit
                    </a>
                </td>

                </td>
        @endforeach
    </table>
@endif
