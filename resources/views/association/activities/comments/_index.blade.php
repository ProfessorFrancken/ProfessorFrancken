<div class="mt-5">
    <h4 class="font-weight-bold">
        Comments
    </h4>

    <ul class="list-unstyled">
        @foreach ($activity->comments as $comment)
            <li class="rounded shadow-sm bg-white p-3 my-4">
                <div class="d-flex justify-content-between">
                    <h5>
                        {{ $comment->member->fullname }}

                        <small class="text-muted mx-1">
                            •
                        </small>
                        <small class="text-muted">
                            {{ $comment->created_at->diffForHumans() }}
                        </small>
                    </h5>
                    @can('update', $comment)
                    <div>
                        <a
                            class="btn btn-text py-0 text-muted"
                            href="{{ action(
                                         [\Francken\Association\Activities\Http\CommentsController::class, 'edit'],
                                         ['activity' => $activity, 'comment' => $comment])
                                  }}"
                        >
                            <i class="fas fa-edit"></i>
                            Edit
                        </a>
                    </div>
                    @endcan
                </div>
                <p>
                    {{ $comment->content }}
                </p>
            </li>
        @endforeach
    </ul>

    @include('association.activities.comments._create')
</div>
