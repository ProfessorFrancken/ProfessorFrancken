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

    <x-forms.textarea name="content" label="Comment" rows="2" />

    <p class="mt-3">
        <button class="btn btn-primary" type="submit">
            Comment
        </button>
    </p>

    {!! Form::close() !!}
    @endcan
</div>
