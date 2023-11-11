@extends('admin.layout')
@section('page-title', 'Products / ' . $product->name)

@section('content')
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <img
                            class="rounded m-3"
                            src="{{ $product->photo_url }}"
                            alt="Logo of {{ $product->name }}"
                            style="max-height: 90px; max-width: 100%;"
                        >
                        <dl>
                            <dt>Price</dt>
                            <dd>
                                &euro;{{ number_format($product->price / 100, 2) }}
                            </dd>
                            <dt>Category</dt>
                            <dd>
                                {{ $product->category }}
                            </dd>
                            @if ($product->position)
                            <dt>Position</dt>
                            <dd>
                                {{ $product->position }}
                            </dd>
                            @endif
                            <dt>Btw</dt>
                            <dd>
                                {{ $product->btw }}
                            </dd>
                        </dl>

                    </div>
                    <p class="mt-3 mb-0 text-muted text-right">
                        Last changed {{ $product->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold">Extra settings</h4>
                        <div>
                            @if ($product->extra !== null)
                                <a
                                    href="{{ action([\Francken\Treasurer\Http\Controllers\AdminProductExtrasController::class, 'edit'], ['product' => $product])}}"
                                    class="btn btn-text btn-sm px-0"
                                >
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                            @else
                                <a
                                    href="{{ action([\Francken\Treasurer\Http\Controllers\AdminProductExtrasController::class, 'create'], ['product' => $product]) }}"
                                    class="btn btn-text btn-sm px-0"
                                >
                                    <i class="fas fa-plus"></i>
                                    Add
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($product->extra)
                        <dl>
                            @if ($product->extra->splash_url)
                            <dt>Splash image</dt>
                            <dd class="text-center">
                                <img
                                    class="rounded"
                                    src="{{ $product->extra->splash_url }}"
                                    alt="Splash image shown after buying the product"
                                    style="max-height: 300px; max-width: 100%;"
                                >
                            </dd>
                            @endif
                            @if ($product->extra->color)
                            <dt>Color</dt>
                            <dd class="mt-2 p-5" style="background-color: {{ $product->extra->color !== '' ? $product->extra->color : '#ffffff' }}">
                                {{ $product->extra->color }}
                            </dd>
                            @endif
                        </dl>
                    @else
                        <div class="bg-light text-center py-5 mt-4">
                            Add button color or splash image settings
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-end">
        <a href="{{ action([\Francken\Treasurer\Http\Controllers\AdminProductsController::class, 'edit'], ['product' => $product]) }}"
            class="btn btn-primary"
        >
            <i class="fas fa-edit"></i>
            Edit
        </a>
    </div>
@endsection
