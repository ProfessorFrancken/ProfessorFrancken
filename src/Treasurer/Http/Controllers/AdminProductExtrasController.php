<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

use Francken\Treasurer\Http\Requests\AdminProductExtraRequest;
use Francken\Treasurer\Product;
use Francken\Treasurer\ProductExtra;
use Francken\Treasurer\ProductFileUploader;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class AdminProductExtrasController
{
    public function create(Product $product) : View
    {
        return view('admin.treasurer.products.extras.create')
            ->with([
                'product' => $product,
                'extra' => new ProductExtra(),
                'breadcrumbs' => [
                    ['url' => action([AdminProductsController::class, 'index']), 'text' => 'Products'],
                    ['url' => action([AdminProductsController::class, 'show'], ['product' => $product]), 'text' => $product->name],
                    ['url' => action([self::class, 'create'], ['product' => $product]), 'text' => 'Add extras'],
                ]
            ]);
    }

    public function store(
        AdminProductExtraRequest $request,
        ProductFileUploader $uploader,
        Product $product
    ) : RedirectResponse {
        $extra = $product->extra()->save(new ProductExtra([
            'kleur' => $request->color(),
            'splash_afbeelding' => null,
        ]));

        Assert::isInstanceOf($extra, ProductExtra::class);

        $uploader->uploadSplashPhoto($request->splash_photo, $extra);

        return redirect()->action([AdminProductsController::class, 'show'], ['product' => $product]);
    }

    public function edit(Product $product) : View
    {
        return view('admin.treasurer.products.extras.edit')
            ->with([
                'product' => $product,
                'extra' => $product->extra,
                'breadcrumbs' => [
                    ['url' => action([AdminProductsController::class, 'index']), 'text' => 'Products'],
                    ['url' => action([AdminProductsController::class, 'show'], ['product' => $product]), 'text' => $product->name],
                    ['url' => action([self::class, 'edit'], ['product' => $product]), 'text' => 'Edit extras'],
                ]
            ]);
    }

    public function update(
        AdminProductExtraRequest $request,
        ProductFileUploader $uploader,
        Product $product
    ) : RedirectResponse {
        Assert::notNull($product->extra);

        $product->extra->update([
            'kleur' => $request->color(),
        ]);

        $uploader->uploadSplashPhoto($request->splash_photo, $product->extra);

        return redirect()->action([AdminProductsController::class, 'show'], ['product' => $product]);
    }
}
