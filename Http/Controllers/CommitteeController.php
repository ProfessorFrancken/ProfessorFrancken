<?php

namespace Http\Controllers;

use Illuminate\Http\Request;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Committees\Committee;
use Francken\Committees\CommitteeId;
use Francken\Committees\Events\CommitteeInstantiated;


class CommitteeController extends Controller
{
    public function index()
    {
        return view('admin.committee');
    }

    public function create_committee(Request $req)
    {
    	$generator = new Version4Generator();
    	$id = new CommitteeId($generator->generate());
    	$committee = Committee::instantiate($id, $req->input('inputName'), $req->input('inputGoal'));
    	
    	$committee
    }
}