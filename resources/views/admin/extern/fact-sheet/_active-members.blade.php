<div class="card my-3">
    <div class="card-body">
        <dl class="row">
            <div class="col">
                <h4 class="card-title">Active members</h4>
                <div class="row">
                    <dt class="col-sm-9">Active members</dt>
                    <dd class="col-sm-3">{{ $activeMembers->total() }}</dd>
                </div>

                <div class="row">
                    <dt class="col-sm-9">International active members</dt>
                    <dd class="col-sm-3">{{ $activeMembers->internationals() }}</dd>
                </div>
            </div>

            <div class="col">

                <h4>Studies</h4>

                @foreach($activeMembers->studies() as $study)
                    <div class="row">
                        <dt class="col-sm-9">{{ $study->study() }}</dt>
                        <dd class="col-sm-3">{{ $study->amount() }}</dd>
                    </div>
                @endforeach

            </div>
            <div class="col">

                <h4>Gender distribution</h4>


                @foreach($activeMembers->genders() as $key => $gender)
                    <div class="row">
                        <dt class="col-sm-9">
                            @if ($key === 'M')
                                Male
                            @elseif ($key === 'V')
                                Female
                            @else
                                Unkown
                            @endif
                        </dt>
                        <dd class="col-sm-3">{{ $gender->count() }}</dd>
                    </div>
                @endforeach
            </div>
        </dl>
    </div>
</div>
