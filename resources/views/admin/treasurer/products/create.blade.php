@extends('admin.layout')
@section('page-title', 'Products / Add a new product')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($product, [
                           'url' => action([\Francken\Treasurer\Http\Controllers\AdminProductsController::class, 'store']),
                           'method' => 'POST',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.treasurer.products._form', ['product' => $product])

                        <x-forms.submit>Add</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
