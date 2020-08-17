@if ($news->title !== '')
    <div class="card my-3">
        <div class="card-body bg-light">
            <h4 class="card-title">
                Publishing
            </h4>
            <p>
                This news article hasn't been published yet. You can either pick a publication date (so that for instance the article will be published on next monday) or save and publish the article directly.
            </p>

            <div class="d-flex justify-content-between align-items-end">
                <x-forms.date name="published_at" :value="optional($news->published_at)->format('Y-m-d')">
                    <x-slot name="label">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        Published at
                    </x-slot>
                </x-forms.date>

                <div class="mb-3">
                    <button type="submit" formaction="{{  action([\Francken\Association\News\Http\AdminNewsController::class, 'publish'], ['news' => $news]) }}" class="btn btn-outline-primary pull-right">
                        <i class="fa fa-upload" aria-hidden="true"></i>

                        Publish
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
