<div class="card">
    <div class="card-body">
        <h3>Miscelanious</h3>

        <x-forms.text name="link" :value="$news->slug" disabled>
            <x-slot name="label">
                <i class="fa fa-link" aria-hidden="true"></i>
                Link slug
            </x-slot>
        </x-forms.text>

        <x-forms.date name="link" :value="$news->updated_at->format('Y-m-d')" disabled>
            <x-slot name="label">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                Latest edit
            </x-slot>
        </x-forms.text>

        <a class="card-link" href="{{ action([\Francken\Association\News\Http\AdminNewsController::class, 'preview'], ['news' => $news]) }}">
            View {{ $news->title }}
        </a>
    </div>
</div>
