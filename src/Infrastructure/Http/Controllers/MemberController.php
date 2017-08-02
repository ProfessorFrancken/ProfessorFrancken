<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Members\Member;
use Francken\Domain\Members\MemberRepository;
use DB;

class MemberController extends Controller
{
    //-------GET---------
    public function index()
    {
        $members = DB::table('members')->get();
        return view('admin.member.index', [
            'members' => $members
        ]);
    }

    //------POST------
    public function addMember(Request $req, MemberRepository $repo)
    {
        $id = MemberId::generate();
        $member = Member::instantiate($id, $req->input('first_name'), $req->input('last_name'));

        $repo->save($member);

        return redirect('/admin/association/member');
    }
}
