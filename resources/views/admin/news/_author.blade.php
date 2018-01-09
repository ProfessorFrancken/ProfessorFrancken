<div class="card mt-3">
    <div class="card-body">

        <h3>
            Author
        </h3>

        <div class="row">
            <div class="col-md-3">
                <img id="profilePicture" alt="" src="{{ $news->authorPhoto() }}" style="cursor: pointer;" class="img-fluid rounded w-100"/>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    {!! Form::text('author-name', $news->authorName(), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::text('author-photo', $news->authorPhoto(), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('author-bio', 'Bio:', ['class' => 'control-label-col']) !!}
                    {!! Form::textarea('bio', "lorem", ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
