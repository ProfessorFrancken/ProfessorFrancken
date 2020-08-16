@extends('admin.layout')
@section('page-title', 'Products / ' . $product->name . ' / Edit')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($product, [
                           'url' => action([\Francken\Treasurer\Http\Controllers\AdminProductsController::class, 'update'], ['product' => $product]),
                           'method' => 'PUT',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}

                        @include('admin.treasurer.products._form', ['product' => $product])

                        {!! Form::submit('Save', ['class' => 'btn btn-outline-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
