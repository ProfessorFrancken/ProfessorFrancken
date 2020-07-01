<?php

declare(strict_types=1);

namespace Francken\Auth\Http\Controllers\Admin;

use DB;
use Francken\Association\LegacyMember;
use Francken\Auth\Account;
use Francken\Auth\Mail\NotifyAboutAccountActivation;
use Illuminate\Contracts\Mail\Mailer;
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
            'members' => LegacyMember::autocomplete(Account::pluck('member_id')),
        ]);
    }

    public function store(Request $request, Mailer $mail)
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

        if ($request->input('send_notification_email', null) === '1') {
            $mail->to($account->email)
                ->queue(new NotifyAboutAccountActivation($account->id));
        }

        return redirect()->action([
            self::class,
            'index'
        ]);
    }
}
