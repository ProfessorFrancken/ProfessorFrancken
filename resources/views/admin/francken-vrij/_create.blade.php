<div class="card">
    {!! Form::open(['url' =>action([\Francken\Association\FranckenVrij\Http\AdminFranckenVrijController::class, 'store']), 'files' => true, 'class' => 'card-body']) !!}

    <h4>Publish a Francken Vrij</h4>

    <x-forms.text name="title" label="Title" :value="$title" />

    <div class="row">
        <div class="col-sm-6">
            <x-forms.text name="volume" label="Volume" :value="$volume" />
        </div>

        <div class="col-sm-6">
            <x-forms.text name="edition" label="Edition" :value="$edition" />
        </div>
    </div>

    <x-forms.form-group name="pdf" label="Fancken Vrij Pdf">
        {!! Form::file('pdf', ['class' => 'form-control-file']) !!}

        <x-slot name="help">
            Upload the pdf of the new Francken Vrij. Note we currently only support uploading files which are less than 40MB.
        </x-slot>
    </x-forms.form-group>

    <x-forms.form-group name="cover" label="Cover">
        {!! Form::file('cover', ['class' => 'form-control-file']) !!}

        <x-slot name="help">
            The cover is optional. If no cover is given then we will generate one from the pdf.
            The cover image should have a size of 175x245 pixels.
        </x-slot>
    </x-forms.form-group>

    <x-forms.submit block>Publish</x-forms.submit>

    {!! Form::close() !!}
</div>
