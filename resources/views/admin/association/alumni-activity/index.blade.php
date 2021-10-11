@extends('admin.layout')
@section('page-title', 'Alumni')

@section('content')
    <p class="lead">
        Participants of the the alumni activity 2022
    </p>
    <div class="card">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Study</th>
                    <th>Graduation year</th>
                    <th>Last updated at</th>
                    <th class="text-right">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alumni as $alumnus)
                    <tr class="alumnus">
                        <td>
                            {{ $alumnus->fullname  }}
                        </td>
                        <td>
                            {{ $alumnus->study  }}
                        </td>
                        <td>
                            {{ $alumnus->graduation_year  }}
                        </td>
                        <td>
                            {{ $alumnus->updated_at->diffForHumans()  }}
                        </td>
                        <td class="text-right">
                            <a href="{{ action([\Francken\Association\AlumniActivity\Http\AdminAlumniActivityController::class, 'edit'], ['alumnus' => $alumnus])  }}" class="text-muted">
                                <i class="far fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-footer">
            {!! $alumni->links() !!}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">
        <a href="{{ action([\Francken\Association\AlumniActivity\Http\AdminAlumniActivityController::class, 'create']) }}"
            class="btn btn-primary"
        >
            <i class="fas fa-plus"></i>
            Add alumnus
        </a>
    </div>
@endsection
