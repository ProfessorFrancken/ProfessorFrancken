@extends('admin.layout')
@section('page-title', 'Subscriptions')

@section('content')
    <p class="lead">
        Below you can find members who have set their fracken vrij subscriptions.
        Use the export button to export addresses of members with an active subscription.
    </p>
    <div class="card">
        <div class="card-header p-0">
            <ul class="nav nav-tabs card-header-tabs m-0">
                @component('admin.francken-vrij.subscriptions._tab-navigation', ['request' => $request, 'select' => 'active-subscription'])
                    Active subscriptions
                    <span class="badge badge-secondary text-white">
                        {{ $active_subscriptions }}
                    </span>
                @endcomponent
                @component('admin.francken-vrij.subscriptions._tab-navigation', ['request' => $request, 'select' => 'recently-expired-subscription'])
                    Recently expired subscriptions
                    <span class="badge badge-secondary text-white">
                        {{ $recently_expired_subscriptions }}
                    </span>
                @endcomponent
                @component('admin.francken-vrij.subscriptions._tab-navigation', ['request' => $request, 'select' => 'expired-subscription'])
                    Expired subscriptions
                    <span class="badge badge-secondary text-white">
                        {{ $expired_subscriptions }}
                    </span>
                @endcomponent
                @component('admin.francken-vrij.subscriptions._tab-navigation', ['request' => $request, 'select' => 'soon-to-be-expired'])
                    Soon to be expired subscriptions
                    <span class="badge badge-secondary text-white">
                        {{ $soon_to_be_expired_subscriptions }}
                    </span>
                @endcomponent
                @component('admin.francken-vrij.subscriptions._tab-navigation', ['request' => $request, 'select' => 'cancelled', 'class' => 'border-left-0'])
                    Cancelled
                    <span class="badge badge-secondary text-white">
                        {{ $cancelled_subscriptions }}
                    </span>
                @endcomponent
                @component('admin.francken-vrij.subscriptions._tab-navigation', ['request' => $request, 'select' => 'all', 'class' => 'border-left-0'])
                    All subscriptions
                    <span class="badge badge-secondary text-white">
                        {{ $all_subscriptions }}
                    </span>
                @endcomponent
            </ul>
        </div>
        @if ($request->selected('soon-to-be-expired'))
            <div class="card-body">
                <strong>Soon to be expired subscriptions</strong>: Subscriptions that will expire within 1 year.
            </div>
        @endif
        @if ($request->selected('recently-expired-subscription'))
            <div class="card-body">
                <strong>Recently expired subscriptions</strong>: Subscriptions that expired within 1 year.
            </div>
        @endif
        @if ($request->selected('cancelled'))
            <div class="card-body">
                <strong>Cancelled subscriptions</strong>: These subscriptions were cancelled manually.
            </div>
        @endif

        <div class="card-body d-none">
            <h4 class="font-weight-bold">
                Search
            </h4>
            <form action="{{ action([\Francken\Association\FranckenVrij\Http\AdminSubscriptionsController::class, 'index']) }}"
                  method="GET"
                  class="form"
            >
                <div class="d-flex mb-3">
                    <div class="mr-2">
                        <x-forms.text
                            name="name"
                            label="Name"
                            placeholder="Search by name"
                            :value="$request->name()"
                        />
                    </div>

                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <button type="submit" class="mx-2 btn btn-sm btn-primary">
                            <i class="fas fa-search"></i>
                            Apply filters
                        </button>
                        <a href="{{ action([\Francken\Association\FranckenVrij\Http\AdminSubscriptionsController::class, 'index'])  }}"
                           class="btn btn-sm btn-text text-primary"
                        >
                            <i class="fas fa-times"></i>
                            Clear filters
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Receive expiration notification?</th>
                    <th>Subscription ends in</th>
                    <th>Last updated at</th>
                    <th class="text-right">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscription)
                    <tr class="subscription">
                        <td>
                            {{ $subscription->member->fullname  }}
                        </td>
                        <td>
                            @if ($subscription->send_expiration_notification)
                                Yes
                                @if ($subscription->notified_at !== null)
                                    <small>(Last notification received {{ $subscription->notified_at->diffForHumans() }})</small>
                                @endif
                            @else
                                No
                            @endif
                        </td>
                        <td>
                            @if ($subscription->subscription_ends_at)
                            {{ $subscription->subscription_ends_at->diffForHumans()  }}
                            @else
                                Canceled
                            @endif
                        </td>
                        <td>
                            {{ $subscription->updated_at->diffForHumans()  }}
                        </td>
                        <td class="text-right">
                            <a href="{{ action([\Francken\Association\FranckenVrij\Http\AdminSubscriptionsController::class, 'edit'], ['subscription' => $subscription])  }}" class="text-muted">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-footer">
            {!! $subscriptions->links() !!}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        @can('export-francken-vrij-subscriptions')
            <a href="{{ action([\Francken\Association\FranckenVrij\Http\AdminSubscriptionsExportController::class, 'index']) }}"
               class="btn btn-primary mr-3"
            >
                <i class="fas fa-cloud-download-alt"></i>
                Export subscriptions
            </a>

            <a href="{{ action([\Francken\Association\FranckenVrij\Http\AdminSubscriptionsController::class, 'create']) }}"
               class="btn btn-primary"
            >
                <i class="fas fa-plus"></i>
                Add subscription
            </a>
        @endcan
    </div>
@endsection
