@component('profile._profile', ['icon' => 'fas fa-graduation-cap'])
    <h5>
        <strong>Student number</strong>:
        <span class="font-weight-light h6">
            {{ $student->studentNumber() }}
        </span>
    </h5>
    <ul class="list-unstyled">
        @foreach ($student->studies() as $study)
            <li class="w-100">
                <h6>
                    {{ $study }}
                </h6>
                {{ $study->startYear() }} - {{ $study->endYear() }}

                @unless ($loop->last)
                    <hr/>
                @endunless
            </li>
        @endforeach
    </ul>
@endcomponent
