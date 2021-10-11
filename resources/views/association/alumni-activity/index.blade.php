@extends('layout.one-column-layout')

@section('content')
    <h1 class="section-header section-header--centered mb-4">Alumni Activity 2022</h1>

    <p class="lead">
        Dear Alumni,
    </p>

    <p class="lead">
        In celebration of our association's half lustrum we invite you to join us in Utrecht on March 12th 2022.
        Take this opportunity to meet your old classmates, board members and “mooie gekken".
        Students in the last phase of their master and former boards are invited as well, this is your chance to network.<br/>

        More information on the schedule will be shared later.
    </p>

    <table class="table mt-5">
        <tr>
            <th>Name</th>
            <th class="text-right">Study</th>
            <th class="text-right">Graduation date</th>
        </tr>

        @foreach ($alumni as $alumnus)
            <tr class=" mb-4 bg-white p-4 rounded shadow-sm">
                <td>
                    {{ $alumnus->fullname  }}
                </td>
                <td class="text-right">
                    {{ $alumnus->study  }}
                </td>
                <td class="text-right">
                    @if ($alumnus->graduation_year)
                        {{ $alumnus->graduation_year  }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection
