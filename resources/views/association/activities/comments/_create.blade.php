<div class='mt-3'>
    @can('create', \Francken\Association\Activities\Comment::class)
    <h5>Add a comment</h5>

    {!!
           Form::open([
               'url' => action(
                   [\Francken\Association\Activities\Http\CommentsController::class, 'store'],
                   ['activity' => $activity]
               ),
           ])
    !!}

    <div class="form-group">
        <label for="content" class="d-none">Comment</label>
        {!!
               Form::textarea(
                   'content',
                   null,
                   ['class' => 'form-control', 'id' => 'content', 'rows' => 2]
               )
        !!}
    </div>

    <p class="mt-3">
        <button class="btn btn-primary" type="submit">
            Comment
        </button>
    </p>

    {!! Form::close() !!}
    @endcan
</div>
