<div class="card my-3">
    <div class="card-body">
        <h4 class="card-title">New first year members per year</h4>

        <div class="row">


            @foreach ($firstYearStudentsPerYear as $year)
                <div class="col-md-3">
                    <h3>
                        {{ $year['year'] }} -
                        {{ $year['year'] + 1 }}
                    </h3>

                    <dl>
                        @foreach($year['studies'] as $study)
                            <div class="row">
                                <dt class="col-sm-9">{{ $study->study() }}</dt>
                                <dd class="col-sm-3">{{ $study->amount() }}</dd>
                            </div>
                        @endforeach

                        <div class="row">
                            <dt class="col-sm-9">Total</dt>
                            <dd class="col-sm-3">
                                <strong>
                                    {{ $year['total'] }}
                                </strong>
                            </dd>
                        </div>
                    </dl>
                </div>
            @endforeach
        </div>
    </div>
</div>
