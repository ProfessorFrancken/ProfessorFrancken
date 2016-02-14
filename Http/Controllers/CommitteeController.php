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

    public function add_member()
    {
        return view('add-member');
    }

    public function post_add_member()
    {
        return redirect('/admin/committee');
    }
}