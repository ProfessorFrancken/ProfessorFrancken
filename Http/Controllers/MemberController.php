<?php

namespace Http\Controllers;

use Illuminate\Http\Request;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Members\MemberId;
use Francken\Members\Member;
use Francken\Members\MemberRepository;

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
        $generator = new Version4Generator();
        $id = new MemberId($generator->generate());
        $member = Member::instantiate($id, $req->input('first_name'), $req->input('last_name'));

        $repo->save($member);

        return redirect('/admin/member');
    }
}
