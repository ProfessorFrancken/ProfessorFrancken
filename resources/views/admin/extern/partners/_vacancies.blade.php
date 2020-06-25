<div class="d-flex justify-content-between">
    <h5 class="h6 font-weight-bold">
        Vacancies
    </h5>
    <div class="mb-0">
        <a
            href="{{ action([\Francken\Extern\Http\AdminVacanciesController::class, 'create'], ['partner' => $partner]) }}"
            class="btn btn-text btn-sm"
        >
            <i class="fas fa-plus"></i>
            Add vacancy
        </a>
    </div>
</div>
<ul class="list-unstyled">
    @forelse($partner->vacancies as $vacancy)
        @include('admin.extern.partners._vacancy', ['vacancy' => $vacancy])
    @empty
        <p>
            This partner's has no vacancies
        </p>
    @endforelse
</ul>
