<li class="p-3 my-3 bg-white">
    <div class="d-flex justify-content-between">
        <h6>
            {{ $vacancy->title }}
        </h6>
    </div>
    <p>
        {{ $vacancy->description }}
    </p>
    <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-start">
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

        <p>
            Last changed {{ $vacancy->updated_at->diffForHumans() }}
        </p>
    </div>
</li>
