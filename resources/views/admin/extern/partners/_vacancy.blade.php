<li class="p-3 my-3 bg-white">
    <div class="d-flex justify-content-between">
        <h6>
            {{ $vacancy->title }}
        </h6>
        <div>
            <a
                href="{{ action(
                         [\Francken\Extern\Http\AdminVacanciesController::class, 'edit'],
                         ['partner' => $partner, 'vacancy' => $vacancy]
                         ) }}"
                class="btn btn-text btn-sm"
            >
                <i class="fas fa-edit"></i>
                Edit
            </a>
        </div>
    </div>
    <p>
        {{ $vacancy->description }}
    </p>
    <p class="mt-3 mb-0 text-muted text-right">
        Last changed {{ $vacancy->updated_at->diffForHumans() }}
    </p>
</li>
