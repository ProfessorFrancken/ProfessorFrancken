<h5 class="d-flex justify-content-between">
    <span>
        Sign up for {{ $activity->name }}
    </span>

    @if (! $activity->signUpSettings->is_free)
        <small class="text-muted font-weight-light mt-2">
            Costs: <i class="fas fa-euro-sign"></i>
            {{ number_format($activity->signUpSettings->costs_per_person / 100, 2) }}
            per person
        </small>
    @endif
</h5>

@if ($activity->signUpSettings->allows_plus_ones)
    <x-forms.number name="plus_ones" label="Are you bringing anyone?" />
@endif

@if ($activity->signUpSettings->ask_for_dietary_wishes)
    <x-forms.text name="dietary_wishes" label="Dietary wishes" placeholder="Flexitarian" />
@endif

@if ($activity->signUpSettings->ask_for_drivers_license)
    <x-forms.checkbox name="has_drivers_license" label="Do you have a drivers license?" />
@endif
