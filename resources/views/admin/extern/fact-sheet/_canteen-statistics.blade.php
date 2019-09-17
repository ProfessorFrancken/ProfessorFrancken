<div class="card my-3">
    <div class="card-body">
        <h4 class="card-title">Active member statistics per week</h4>

        <p class="card-text">
            The following shows a listing of the amount of members that have purchased one or more products form our "streep system" in the given day or week.
        </p>

    </div>
    <table class="table table-hover mb-0">
        <thead class="thead-inverse">
            <tr>
                <th>Week</th>
                @foreach ($weeklyStats[0]['stats'] as $statsOfDay)
                    @if ($loop->last)
                    <th class="text-right">
                    @else
                    <th class="text-left">
                    @endif
                        {{ $statsOfDay["day"] }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($weeklyStats as $stats)
                <tr>
                    <th>
                        {{ $stats['week'] }}
                    </th>
                    @foreach ($stats['stats'] as $statsOfDay)
                        @if ($loop->last)
                        <td class="text-right bg-primary text-white">
                        @else
                        <td class="text-left">
                        @endif
                            {{ $statsOfDay['members'] }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
