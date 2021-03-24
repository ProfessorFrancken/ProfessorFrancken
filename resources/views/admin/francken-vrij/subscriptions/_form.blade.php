<x-forms.select
    name="subsription_ends_at"
    label="Subscrive for new physical issues of the Francken Vrij until"
    placeholder=""
    :options="$extensionOptions"
    :value="$subscriptionEndsAt"
/>

<x-forms.checkbox
    name="send_expiration_notification"
    label="Notify member when subscription expires."
    :value="$subscription->send_expiration_notification"
>
    @if ($subscription->notified_at !== null)
    <x-slot name="help">
        The last notification was sent {{ $subscription->notified_at->diffForHumans() }}
    </x-slot>
    @endif

</x-forms.checkbox>
