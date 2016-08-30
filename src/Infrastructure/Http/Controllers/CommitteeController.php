<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Illuminate\Http\Request;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;
use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\CommitteeRepository;
use Francken\Domain\Members\MemberId;
use App\ReadModel\CommitteesList\CommitteesListProjector;
use DB;

class CommitteeController extends Controller
{
    //-------GET---------
    public function index()
    {
        $committees = DB::table('committees_list')->get();

        return view('admin.committee.index', [
            'committees' => $committees
        ]);
    }

    public function store(Request $req, CommitteeRepository $repo)
    {
        $generator = new Version4Generator();
        $id = new CommitteeId($generator->generate());
        $committee = Committee::instantiate($id, $req->input('inputName'), $req->input('inputGoal'));

        $repo->save($committee);

        return redirect('/admin/committee');
    }

    public function show($id)
    {
        $committee = DB::table('committees_list')->where('uuid', $id)->first();

        return view('admin.committee.show', [
            'committee' => $committee
        ]);
    }

    public function update(Request $req, CommitteeRepository $repo, $id)
    {
        $committee = $repo->load($id);
        $committee->edit($req->input('name'), $req->input('goal'));
        $repo->save($committee);

        return redirect('/admin/committee/' . $id);
    }

    public function addMember(CommitteeRepository $repo, $committeeId, $memberId)
    {
        $committee = $repo->load($committeeId);
        $committee->joinByMember(new MemberId($memberId));
        $repo->save($committee);

        return back();
    }

    public function removeMember(CommitteeRepository $repo, $committeeId, $memberId)
    {
        $committee = $repo->load($committeeId);
        $committee->leftByMember(new MemberId($memberId));
        $repo->save($committee);

        return back();
    }

    public function searchMember(Request $req)
    {
        $members = DB::table('members')
            ->where('first_name', 'like', $req->input('first_name') . '%')
            ->where('last_name', 'like', $req->input('last_name') . '%')
            ->get();

        return back()->with([
            'searchResults' => $members
        ]);
    }
}
