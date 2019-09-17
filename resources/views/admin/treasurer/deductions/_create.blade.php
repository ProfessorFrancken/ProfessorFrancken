<div class="card">
    <div class="card-header">
        <h3 class="h5 mb-0">
        Upload a new deduction
        </h3>
    </div>

    {!!
       Form::model($deduction, [
           'url' => action([\Francken\Treasurer\Http\Controllers\DeductionsController::class, 'store']),
           'method' => 'POST',
           'enctype' => 'multipart/form-data'
       ])
    !!}
    <div class="card-body">
        <p>
            Upload the deduction file after uploading it to the ABN Amro.
            After uploading the file and verifying that there is no invalid data you can send the deduction email to the members.
        </p>

        @include('admin.treasurer.deductions._form', ['deduction' => $deduction])
    </div>

    <div class="card-footer">
        {!! Form::submit('Upload', ['class' => 'btn btn-outline-success']) !!}
    </div>
    {!! Form::close() !!}
</div>
