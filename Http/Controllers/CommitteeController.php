<?php

namespace Http\Controllers;

use Illuminate\Http\Request;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Committees\Committee;
use Francken\Committees\CommitteeId;
use Francken\Committees\Events\CommitteeInstantiated;
use Francken\Committees\CommitteeRepository;

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

    public function show($id)
    {
        $committee = DB::table('committees_list')->where('uuid', $id)->first();

        return view('admin.committee.show', [
            'committee' => $committee
        ]);
    }

    //------POST------
    public function createCommittee(Request $req, CommitteeRepository $repo)
    {
        $generator = new Version4Generator();
        $id = new CommitteeId($generator->generate());
        $committee = Committee::instantiate($id, $req->input('inputName'), $req->input('inputGoal'));

        $repo->save($committee);

        return redirect('/admin/committee');
    }

    public function addMember()
    {
        return redirect('/admin/committee');
    }

    //------PUT-----
    public function editCommittee(Request $req, CommitteeRepository $repo)
    {
        $committee = $repo->load($req->input('id'));

        $committee->edit($req->input('name'), $req->input('goal'));
        $repo->save($committee);

        return redirect('/admin/committee/' . $req->input('id'));
    }
}