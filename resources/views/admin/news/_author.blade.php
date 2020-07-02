<div class="card mt-3">
    <div class="card-body">
        <h3>
            Author
        </h3>

        <div class="row">
            <div class="col-md-3">
                <img id="profilePicture" alt="" src="{{ $news->author_photo }}" style="cursor: pointer;" class="img-fluid rounded w-100"/>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    {!! Form::text('author_name', $news->author_name, ['class' => 'form-control', 'placeholder' => 'Author name']) !!}
                </div>

                <div class="form-group">
                    {!! Form::text('author_photo', $news->author_photo, ['class' => 'form-control', 'placeholder' => 'Url to picture of author']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
