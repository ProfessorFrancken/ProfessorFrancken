<h5 class="mt-4 mx-2">
    <i class="fas fa-graduation-cap"></i>
    Study details
    <small class="text-muted" title="Student number">
        (Student number: {{ $registration->student_number }})
    </small>
</h5>
<div class="bg-light p-3">
    <ul class="list-unstyled mb-0">
        @foreach ($registration->studies as $study)
            <li>
                <strong>
                    {{ $study->study() }}
                </strong>
                ({{
                $study->startDate()->format('Y-m')
                }}{{
                ($study->graduationDate() !== null) ? "- {$study->graduationDate()->format('Y-md')}" : ""
                }})
            </li>
        @endforeach

    </ul>
</div>
