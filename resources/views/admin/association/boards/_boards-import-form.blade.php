<li class="p-3 mb-2">

    {!!
       Form::open([
           'url' => action([\Francken\Association\Boards\Http\Controllers\AdminImportsController::class, 'import']),
           'method' => 'POST',
           'enctype' => 'multipart/form-data',
           'class' => 'border border-primary rounded-lg p-4 bg-light text-center',
           'id' => 'import-boards-form'
       ])
    !!}
        <h3 class="my-3 section-header section-header--centered">
            The boards database is empty
        </h3>

        <p>Go do something about it!</p>

        <label for="import" class="btn btn-primary btn-lg mr-4 my-4">
            <i class="fas fa-cloud-upload-alt"></i>
            Import
        </label>

        {!! Form::file('import', ['class' => 'sr-only', 'id' => 'import']) !!}
    {!! Form::close() !!}
</li>

<script>
document.getElementById("import").onchange = function() {
    document.getElementById("import-boards-form").submit();
};
</script>
