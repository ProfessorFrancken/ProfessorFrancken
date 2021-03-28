@extends('profile.layout')

@section('content')
    <h4 class="font-weight-bold section-header">
        <i class="fas fa-book-open"></i>
        Francken Vrij subscription
    </h4>


    <div class="card my-3">
        {!!
               Form::model(
                   $member, [
                   'url' => action([\Francken\Association\Members\Http\FranckenVrijSubscriptionController::class, 'update']),
               ])
        !!}
        <div class="card-body">

            @method('PUT')

            @if ($subscription->subscription_ends_at !== null)
                <p>
                    Your subscription of the Francken Vrij ends in {{ (new \Carbon\Carbon($subscription->subscription_ends_at))->diffForHumans()  }} ({{ $subscription->subscription_ends_at->format("Y-m-d")  }}).
                </p>

                <x-forms.select
                    name="subsription_ends_at"
                    label="Subscribe for new physical issues of the Francken Vrij until"
                    placeholder=""
                    :options="$extensionOptions"
                    :value="'September ' . $subscription->subscription_ends_at->format('Y')"
                />
            @else
                <p>
                    Your currently don't have an active <strong>physical</strong> subscription for the Francken Vrij.
                </p>

                <x-forms.select
                    name="subsription_ends_at"
                    label="Subscribe for new physical issues of the Francken Vrij until"
                    placeholder=""
                    :options="$extensionOptions"
                />
            @endif

            <p>
                @if ($subscription->subscription_ends_at !== null)
                    We'll send the Francken Vrij to the address shown below:
                @else
                    Once activated we will send new issues of the Francken Vrij to the address below:
                @endif

                <div class="p-2 bg-light">
                    {{  $member->address->toString() }}
                </div>
            </p>
            <x-forms.checkbox
                name="send_expiration_notification"
                label="Notify me per email when my subscription expires."
                :value="$subscription->send_expiration_notification"
            />
        </div>

        <div class="card-footer">
            @if ($subscription->subscription_ends_at !== null)
                <x-forms.submit>Update subscription</x-forms.submit>
            @else
                <x-forms.submit>Subscribe</x-forms.submit>
            @endif
        </div>

        {!! Form::close() !!}
    </div>


    <div class="card mt-4">
        <div class="card-body">
            <h6>Why do I need to extend my Francken Vrij subscription?</h6>
            <p class="mb-0">
                We want to make sure the Francken Vrij is easily accessible to enjoy by all.
                As the association looks to reduce its paper use, we would like to make sure that we don't send physical copies to members whose addresses changed or who no longer wish to receive the Francken Vrij.
            </p> 
        </div>
    </div>
    
@endsection
