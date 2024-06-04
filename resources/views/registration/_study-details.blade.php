<div class="row">
    <div class="col-sm-8">
        <x-forms.text name="student_number" label="Student number" placeholder="Student number" required />
    </div>
</div>

<ul class="list-unstyled studies">
    @foreach (range(0, $amountOfStudies) as $number)
        <li>
            <div class="row">
                <div class="col-sm-3">
                    <x-forms.text
                        :name='"study_name[{$number}]"'
                        label="Study"
                        placeholder="Bsc or Msc Applied Physics"
                        required
                    />
                </div>
                <div class="col-sm-3">
                    <x-forms.month
                        :name='"study_starting_date[{$number}]"'
                        label="Starting date"
                        required
                    />
                </div>
                <div class="col-sm-3">
                    <x-forms.month
                        :name='"study_graduation_date[{$number}]"'
                        label="Graduation date (optional)"
                    />
                </div>
            </div>
        </li>
    @endforeach
</ul>

<button class="btn btn-link" id="addAdditionalStudy">
    <i class="fa fa-plus-circle" aria-hidden="true"></i>
    Add another study
</button>
