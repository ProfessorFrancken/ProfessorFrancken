<?php

declare(strict_types=1);

namespace Francken\Treasurer\Http\Controllers;

use DateTimeImmutable;
use Francken\Treasurer\Http\Requests\AdminSearchTransactionsRequest;
use Francken\Treasurer\Http\Requests\AdminTransactionRequest;
use Francken\Treasurer\Product;
use Francken\Treasurer\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminTransactionsController
{
    public function index(AdminSearchTransactionsRequest $request) : View
    {
        $transactionsSearchQuery = Transaction::query()
            ->when($request->memberId(), function (Builder $query, int $memberId) : void {
                $query->where('lid_id', $memberId);
            })
            ->when($request->productId(), function (Builder $query, int $productId) : void {
                $query->where('product_id', $productId);
            })
            ->when($request->from(), function (Builder $query, DateTimeImmutable $from) : void {
                $query->whereDate('tijd', '>=', $from);
            })
            ->when($request->until(), function (Builder $query, DateTimeImmutable $until) : void {
                $query->whereDate('tijd', '<=', $until);
            });

        $transactions = $transactionsSearchQuery
            ->orderBy('tijd', 'desc')
            ->with(['product', 'purchasedBy'])
            ->paginate(50)
            ->appends($request->except('page'));

        $products = Product::orderBy('naam')->get()
            ->mapWithKeys(fn ($product) => [$product->id => $product->name])
            ->prepend("All", null);

        return view('admin.treasurer.transactions.index')
            ->with([
                'request' => $request,
                'products' => $products,
                'transactions' => $transactions,
                'total' => $transactionsSearchQuery->count(),
                'totalRevenue' => $transactionsSearchQuery->sum('totaalprijs'),
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Transactions'],
                ]
            ]);
    }


    public function create() : View
    {
        $products = Product::all()
            ->mapWithKeys(fn ($product) => [$product->id => $product->name]);

        return view('admin.treasurer.transactions.create')
            ->with([
                'transaction' => new Transaction(),
                'products' => $products,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Transactions'],
                    ['url' => action([self::class, 'create']), 'text' => 'Add a transaction'],
                ]
            ]);
    }

    public function store(AdminTransactionRequest $request) : RedirectResponse
    {
        $product = Product::findOrFail($request->productId());

        $transaction = Transaction::create([
            "lid_id" => $request->memberId(),
            "product_id" => $request->productId(),
            "aantal" => 1,
            "prijs" => $product->prijs,
            "totaalprijs" => $product->prijs,
            "tijd" => $request->time(),
        ]);

        return redirect()->action([self::class, 'edit'], ['transaction' => $transaction]);
    }

    public function edit(Transaction $transaction) : View
    {
        $products = Product::all()
            ->mapWithKeys(fn ($product) => [$product->id => $product->name]);

        return view('admin.treasurer.transactions.edit')
            ->with([
                'transaction' => $transaction,
                'products' => $products,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Transactions'],
                    ['url' => action([self::class, 'edit'], ['transaction' => $transaction]), 'text' => $transaction->id],
                    ['url' => action([self::class, 'edit'], ['transaction' => $transaction]), 'text' => 'Edit'],
                ]
            ]);
    }

    public function update(AdminTransactionRequest $request, Transaction $transaction) : RedirectResponse
    {
        $transaction->update([
            "lid_id" => $request->memberId(),
            "product_id" => $request->productId(),
            "aantal" => $request->amount(),
            "prijs" => $request->price(),
            "totaalprijs" => $request->totalPrice(),
            "tijd" => $request->time(),
        ]);

        return redirect()->action([self::class, 'edit'], ['transaction' => $transaction]);
    }
}
