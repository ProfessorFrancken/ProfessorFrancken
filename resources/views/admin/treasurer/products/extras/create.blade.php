@extends('admin.layout')
@section('page-title', 'Products / ' . $product->name . ' / Add extras')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body bg-light">
                    {!!
                       Form::model($extra, [
                           'url' => action([\Francken\Treasurer\Http\Controllers\AdminProductExtrasController::class, 'store'], ['product' => $product]),
                           'method' => 'POST',
                           'enctype' => 'multipart/form-data'
                       ])
                    !!}
                        @include('admin.treasurer.products.extras._form', ['product' => $product])

                        <x-forms.submit>Add</x-forms.submit>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
