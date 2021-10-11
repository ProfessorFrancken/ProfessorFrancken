<?php

declare(strict_types=1);

namespace Francken\Association\AlumniActivity\Http;

use Francken\Association\AlumniActivity\Alumnus;
use Francken\Association\FranckenVrij\Http\Requests\AdminSearchSubscriptionsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AdminAlumniActivityController
{
    public function index(AdminSearchSubscriptionsRequest $request) : View
    {
        $alumni = Alumnus::orderBy('updated_at', 'desc')->paginate(100);

        return view('admin.association.alumni-activity.index')
            ->with([
                'request' => $request,
                'alumni' => $alumni,

                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([self::class, 'index']), 'text' => 'Alumni activity 2022'],
                ]
            ]);
    }

    public function create() : View
    {
        $alumnus = new Alumnus();

        return view('admin.association.alumni-activity.create')
            ->with([
                'alumnus' => $alumnus,
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([self::class, 'index']), 'text' => 'Alumni activity 2022'],
                    ['url' => action([self::class, 'create']), 'text' => 'Create'],
                ]
            ]);
    }

    public function store(AdminAlumnusRequest $request) : RedirectResponse
    {
        Alumnus::create([
            'member_id' => $request->memberId(),
            'fullname' => $request->fullname(),
            'study' => $request->study(),
            'graduation_year' => $request->graduationYear(),
        ]);

        return redirect()->action([self::class, 'index']);
    }

    public function edit(Alumnus $alumnus) : View
    {
        return view('admin.association.alumni-activity.edit')
            ->with([
                'alumnus' => $alumnus,
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([self::class, 'index']), 'text' => 'Alumni activity 2022'],
                    ['url' => action([self::class, 'edit'], ['alumnus' => $alumnus]), 'text' => $alumnus->fullname],
                ]
            ]);
    }

    public function update(AdminAlumnusRequest $request, Alumnus $alumnus) : RedirectResponse
    {
        $alumnus->update([
            'member_id' => $request->memberId(),
            'fullname' => $request->fullname(),
            'study' => $request->study(),
            'graduation_year' => $request->graduationYear(),
        ]);

        return redirect()->action([self::class, 'index']);
    }

    public function destroy(Alumnus $alumnus) : RedirectResponse
    {
        $alumnus->delete();

        return redirect()->action([self::class, 'index']);
    }
}
