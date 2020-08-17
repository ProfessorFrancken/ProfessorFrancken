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
                <x-forms.text
                    name="author_name"
                    label="Author name"
                    placeholder="Author name"
                    :value="$news->author_name"
                />

                <x-forms.text
                    name="author_photo"
                    label="Author photo"
                    placeholder="Url to picture of author"
                    :value="$news->author_photo"
                />
            </div>
        </div>
    </div>
</div>
