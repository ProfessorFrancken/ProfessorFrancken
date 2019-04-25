<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers\Admin;

use DB;
use Francken\Auth\Account;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

final class AccountsController
{
    public function index()
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

    public function show(Account $account)
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

    public function create()
    {
        return view('admin.compucie.accounts.create', [
            'account' => new Account(),
            'members' => $this->members(), // TODO: only sellect members that do not yet have an account
        ]);
    }

    public function store(Request $request)
    {
        $member_id = $request->input('member_id');

        if ( ! $member_id) {
            return redirect()->back();
        }

        $email = DB::connection('francken-legacy')
            ->table('leden')
            ->where('is_lid', true)
            ->where('id', $member_id)
            ->first()
            ->emailadres;

        $account = Account::activate(
            $member_id,
            $email,
            \Hash::make(str_random(32))
        );

        return redirect()->action([
            self::class,
            'index'
        ]);
    }

    private function members()
    {
        $activated_accounts = Account::pluck('member_id');

        return DB::connection('francken-legacy')
            ->table('leden')
            ->where('is_lid', true)
            ->whereNotIn('id', $activated_accounts)
            ->select(['id',  'voornaam', 'tussenvoegsel', 'achternaam'])
            ->orderBy('id', 'desc')
            ->get();
    }
}
