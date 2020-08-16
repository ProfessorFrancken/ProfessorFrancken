<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

use Francken\Treasurer\Http\Requests\AdminProductRequest;
use Francken\Treasurer\Http\Requests\AdminSearchProductsRequest;
use Francken\Treasurer\Product;
use Francken\Treasurer\ProductFileUploader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminProductsController
{
    public function index(AdminSearchProductsRequest $request) : View
    {
        $products = Product::search($request)
            ->when(
                $request->category('beer'),
                fn (Builder $query) : Builder => $query->beer()
            )
            ->when(
                $request->category('food'),
                fn (Builder $query) : Builder => $query->food()
            )
            ->when(
                $request->category('soda'),
                fn (Builder $query) : Builder => $query->soda()
            )
            ->orderBy('naam', 'ASC')
            ->paginate(40)
            ->appends($request->except('page'));

        return view('admin.treasurer.products.index')
            ->with([
                'request' => $request,
                'beerProducts' => Product::search($request)->beer()->count(),
                'foodProducts' => Product::search($request)->food()->count(),
                'sodaProducts' => Product::search($request)->soda()->count(),
                'totalProducts' => Product::search($request)->count(),
                'products' => $products,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Products'],
                ]
            ]);
    }

    public function create() : View
    {
        return view('admin.treasurer.products.create')
            ->with([
                'product' => new Product(),
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Products'],
                    ['url' => action([self::class, 'create']), 'text' => 'Add a product'],
                ]
            ]);
    }

    public function store(
        AdminProductRequest $request,
        ProductFileUploader $uploader
    ) : RedirectResponse {
        $product = Product::create([
            'naam' => $request->name(),
            'prijs' => $request->price() / 100,
            'categorie' => $request->dutchCategory(),
            'beschikbaar' => $request->available(),
            'positie' => $request->position(),
            'afbeelding' => '',
            'btw' => 0.21,
            'eenheden' => 1,
        ]);

        $uploader->uploadPhoto($request->photo, $product);

        return redirect()->action([self::class, 'show'], ['product' => $product]);
    }

    public function show(Product $product) : View
    {
        return view('admin.treasurer.products.show')
            ->with([
                'product' => $product,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Products'],
                    ['url' => action([self::class, 'show'], ['product' => $product]), 'text' => $product->name],
                ]
            ]);
    }

    public function edit(Product $product) : View
    {
        return view('admin.treasurer.products.edit')
            ->with([
                'product' => $product,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Products'],
                    ['url' => action([self::class, 'show'], ['product' => $product]), 'text' => $product->name],
                    ['url' => action([self::class, 'edit'], ['product' => $product]), 'text' => 'Edit'],
                ]
            ]);
    }

    public function update(
        AdminProductRequest $request,
        ProductFileUploader $uploader,
        Product $product
    ) : RedirectResponse {
        $product->update([
            'naam' => $request->name(),
            'prijs' => $request->price() / 100,
            'categorie' => $request->dutchCategory(),
            'beschikbaar' => $request->available(),
            'positie' => $request->position(),
        ]);

        $uploader->uploadPhoto($request->photo, $product);

        return redirect()->action([self::class, 'show'], ['product' => $product]);
    }
}
