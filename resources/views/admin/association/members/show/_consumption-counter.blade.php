<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4>
                Consumption counter
            </h4>
            <div>
                @if($member->payment_details->deductAdditionalCosts())
                    <i class="far fa-check-circle text-muted"></i>
                @else
                    <i class="far fa-times-circle text-danger"></i>
                @endif
            </div>
        </div>

        @if(!$member->payment_details->deductAdditionalCosts())
            <div class="my-3 bg-light py-3 px-2">
                <p class="mb-0 text-center" style="font-size: 0.8rem">
                    {{ $member->fullname }} is not listed in the consumption counter.
                </p>
            </div>
        @endif

        @if ($consumptionCounterExtra)
            <div class="my-3 bg-light py-3 px-2">
                <div class="d-flex justify-content-start">
                    <div style="background-color: {{ $consumptionCounterExtra->color ?? ''}}; max-height: 7em; width: 7em" class="mr-3">
                        <img src="{{  $consumptionCounterExtra->photo_url}}" class="img-fluid" style="max-height: 100%;" />
                    </div>
                    <div>
                        <h6 class="mb-0">
                            {{ $consumptionCounterExtra->display_name }}
                            <small>
                                @if($consumptionCounterExtra->prominent > 0)
                                    (+{{ $consumptionCounterExtra->prominent }})
                                @elseif($consumptionCounterExtra->prominent < 0)
                                    ({{ $consumptionCounterExtra->prominent }})
                                @endif
                            </small>
                        </h6>
                        @if($consumptionCounterExtra->has_small_button)
                            <i class="fas fa-check text-muted"></i>
                            Small button
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
