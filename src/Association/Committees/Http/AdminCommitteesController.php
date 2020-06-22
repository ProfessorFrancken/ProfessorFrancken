<?php

declare(strict_types=1);

namespace Francken\Association\Committees\Http;

use DB;
use Exception;
use Francken\Application\Committees\CommitteesListRepository;
use Francken\Domain\Committees\Committee;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Committees\CommitteeRepository;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\MemberId;
use Francken\Infrastructure\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCommitteesController extends Controller
{
    private $committeeRepo;

    public function __construct(CommitteesListRepository $committees)
    {
        $this->committeeRepo = $committees;
    }

    public function index()
    {
        $committees = $this->committeeRepo->findAll();

        return view('admin.committee.index', [
            'committees' => $committees
        ]);
    }

    public function create()
    {
        return view('admin.committee.create');
    }

    public function store(Request $req, CommitteeRepository $repo)
    {
        $id = CommitteeId::generate();
        $committee = Committee::instantiate($id, $req->input('name'), $req->input('summary'));

        if ($req->filled('page')) {
            $committee->setCommitteePage($req->input('page', ''));
        }
        $email = $req->input('email');
        if ( ! empty($email)) {
            $committee->setEmail(new Email($req->input('email')));
        } else {
            $committee->setEmail(null);
        }

        $repo->save($committee);

        return redirect('/admin/association/committees');
    }

    public function show(string $id)
    {
        $committee = $this->committeeRepo->find(new CommitteeId($id));

        return view('admin.committee.show', [
            'committee' => $committee
        ]);
    }

    public function update(Request $req, CommitteeRepository $repo, string $id)
    {
        $committee = $repo->load(new CommitteeId($id));
        $committee->edit($req->input('name'), $req->input('goal'));
        $committee->setCommitteePage($req->input('page'));
        try {
            $committee->setEmail(new Email($req->input('email')));
        } catch (Exception $e) {
            $committee->setEmail(null);
        }

        $repo->save($committee);

        return redirect('/admin/association/committees/' . $id);
    }

    public function addMember(CommitteeRepository $repo, string $committeeId, string $memberId)
    {
        $committee = $repo->load(new CommitteeId($committeeId));
        $committee->joinByMember(new MemberId($memberId));
        $repo->save($committee);

        return back();
    }

    public function removeMember(CommitteeRepository $repo, string $committeeId, string $memberId)
    {
        $committee = $repo->load(new CommitteeId($committeeId));
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
