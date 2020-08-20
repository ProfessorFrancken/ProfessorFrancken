<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers\Admin;

use Francken\Association\LegacyMember;
use Francken\Auth\Account;
use Francken\Auth\Permission;
use Francken\Auth\Role;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class AccountsController
{
    public function index() : View
    {
        $accounts = Account::with(['roles', 'permissions'])
            ->paginate(30);

        return view('admin.compucie.accounts.index', [
            'accounts' => $accounts,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Accounts'],
            ]
        ]);
    }

    public function show(Account $account) : View
    {
        $roles = Role::where('guard_name', 'web')->get();
        $permissions = Permission::where('guard_name', 'web')->get();

        return view('admin.compucie.accounts.show', [
            'account' => $account,
            'permissions' => $permissions,
            'roles' => $roles,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Accounts'],
                ['url' => action([static::class, 'show'], $account->id), 'text' => $account->email],
            ]
        ]);
    }

    public function create() : View
    {
        return view('admin.compucie.accounts.create', [
            'account' => new Account(),
            'members' => LegacyMember::autocomplete(Account::pluck('member_id')),
        ]);
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'member_id' => ['required', 'integer', 'exists:francken-legacy.leden,id'],
        ]);

        $memberId = (int)$request->input('member_id');

        $member = LegacyMember::query()
            ->where('is_lid', true)
            ->where('emailadres', '<>', '')
            ->findOrFail($memberId);

        Assert::notNull($member->emailadres);

        Account::activate($memberId, $member->emailadres, Hash::make(Str::random(32)));

        return redirect()->action([
            self::class,
            'index'
        ]);
    }
}
