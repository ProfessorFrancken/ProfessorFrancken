<li class="p-3 bg-light my-3">
    <h5 class="h6 font-weight-bold">
        Vacancies
    </h5>

    <ul class="list-unstyled">
        @forelse($partner->vacancies as $vacancy)
            @include('admin.extern.partners._vacancy', ['vacancy' => $vacancy])
        @empty
            <p>
                This partner's has no vacancies
            </p>
        @endforelse
    </ul>

    <a
        href="{{ action([\Francken\Extern\Http\AdminVacanciesController::class, 'create'], ['partner' => $partner]) }}"
        class="btn btn-text btn-sm"
    >
        <i class="fas fa-plus"></i>
        Add vacancy
    </a>
</li>
