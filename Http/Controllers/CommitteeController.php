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
    public function index()
    {
        $committees = DB::table('committees_list')->get();

        return view('committee', [
            'committees' => $committees
        ]);
    }

    public function create_committee()
    {
        return view('create-committee');
    }

    public function post_create_committee(Request $req, CommitteeRepository $repo)
    {
    	$generator = new Version4Generator();
    	$id = new CommitteeId($generator->generate());
    	$committee = Committee::instantiate($id, $req->input('inputName'), $req->input('inputGoal'));

        $repo->save($committee);

        return redirect('/admin/committee');
    }

    public function add_member($id)
    {
        $committee = DB::table('committees_list')->where('uuid', $id)->first();

        return view('add-member', [
            'committee' => $committee
        ]);
    }

    public function post_add_member()
    {
        return redirect('/admin/committee');
    }

    public function post_edit_committee(Request $req, CommitteeRepository $repo)
    {
        $committee = $repo->load($req->input('id'));
        // $committee->edit($req->input('name'), $req->input('goal'));
        // $repo->save($committee);
        echo $committee->getAggregateRootId();

        // return redirect('/admin/committee')
    }
}