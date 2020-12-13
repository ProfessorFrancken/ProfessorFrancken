@extends('admin.layout')
@section('page-title', $page->title . ' / Edit')

@section('content')
    <div class="card">
        <div class="card-body">
            {!!
                   Form::model($page, [
                       'url' => action(
                           [\Francken\Shared\Http\Controllers\Admin\PagesController::class, 'update'], ['page' => $page]
                       ),
                       'method' => 'PUT',
                   ])
            !!}

            <div class="row">
                <div class="col-3">
                    <x-forms.text name="title" label="Title" />
                    <x-forms.textarea name="description" label="Description" help="The description is used to improve our Google search results. Should be 1 paragraph."/>
                    <x-forms.text name="slug" label="Slug" help="This determines the url of this page" />
                    <x-forms.checkbox name="is_published" label="Publish custom page" />
                </div>
                <div class="col-9">
                    <x-forms.markdown />
                </div>
            </div>

            <x-forms.submit>Save</x-forms.submit>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
