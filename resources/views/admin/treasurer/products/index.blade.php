@extends('admin.layout')
@section('page-title', 'Products')

@section('content')
    <div class="card">
        <div class="card-header p-0">
            <ul class="nav nav-tabs card-header-tabs m-0">
                @component('admin.treasurer.products._tab-navigation', ['request' => $request, 'select' => 'all', 'class' => 'border-left-0'])
                    <i class="fas fa-store"></i>
                    All products
                    <span class="mx-1 badge badge-secondary text-white">
                        {{ $totalProducts }}
                    </span>
                @endcomponent
                @component('admin.treasurer.products._tab-navigation', ['request' => $request, 'select' => 'beer'])
                    <i class="fas fa-beer"></i>
                    Beer
                    <span class="mx-1 badge badge-secondary text-white">
                        {{ $beerProducts }}
                    </span>
                @endcomponent
                @component('admin.treasurer.products._tab-navigation', ['request' => $request, 'select' => 'food'])
                    <i class="fas fa-drumstick-bite"></i>
                    Food
                    <span class="mx-1 badge badge-secondary text-white">
                        {{ $foodProducts }}
                    </span>
                @endcomponent
                @component('admin.treasurer.products._tab-navigation', ['request' => $request, 'select' => 'soda'])
                    <i class="fas fa-coffee"></i>
                    Soda
                    <span class="mx-1 badge badge-secondary text-white">
                        {{ $sodaProducts }}
                    </span>
                @endcomponent
            </ul>
        </div>

        <div class="card-body">
            <h4 class="font-weight-bold">
                Search
            </h4>
            <form action="{{ action([\Francken\Treasurer\Http\Controllers\AdminProductsController::class, 'index']) }}"
                  method="GET"
                  class="form"
            >
                <div class="d-flex mb-3">
                    <div class="form-group mr-2 mb-0">
                        <label for="name">Name</label>
                        {!! Form::text('name', $request->name(), ['placeholder' => 'Search by name', 'class' => 'form-control'])  !!}
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <button type="submit" class="mx-2 btn btn-sm btn-primary">
                            <i class="fas fa-search"></i>
                            Apply filters
                        </button>
                        <a href="{{ action([\Francken\Treasurer\Http\Controllers\AdminProductsController::class, 'index'])  }}"
                           class="btn btn-sm btn-text text-primary"
                        >
                            <i class="fas fa-times"></i>
                            Clear filters
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-conten-between">
                    <div class="form-group form-check mx-2">
                        {!! Form::checkbox('unavailable', true, $request->unavailable(), ['class' => 'form-check-input', 'id' => 'unavailable'])  !!}
                        <label class="form-check-label" for="unavailable">Show unavailable products</label>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th colspan="2">Product</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td style="width: 200px;" class="align-middle">
                                <img
                                    class="rounded ml-2 my-2"
                                    src="{{ $product->photo_url }}"
                                    alt="Photo of {{ $product->name }}"
                                    style="width: 150px; max-width: 150px; max-height: 80px; object-fit: cover;"
                                />
                        </td>
                        <td>
                            <a href="{{ action(
                                        [\Francken\Treasurer\Http\Controllers\AdminProductsController::class, 'show'],
                                        ['product' => $product]
                                        ) }}"
                            >
                                <h4 class='d-flex flex-column h6'>
                                    <span>
                                        <i class="fas fa-{{ $product->category_icon }} fa-sm mr-1 text-muted"></i>
                                        {{ $product->name }}
                                    </span>
                                </h4>

                                <p class='mb-0'>
                                    <span class="font-weight-normal">
                                        &euro;{{ number_format($product->price / 100, 2) }}
                                    </span>
                                    @if (! $product->available)
                                        <small>
                                            (Not available)
                                        </small>
                                    @endif
                                </p>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card-footer">
            {!! $products->links() !!}
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        <a href="{{ action([\Francken\Treasurer\Http\Controllers\AdminProductsController::class, 'create']) }}"
           class="btn btn-primary"
        >
            <i class="fas fa-plus"></i>
            Add a product
        </a>
    </div>
@endsection
