<?php

declare(strict_types=1);

namespace Francken\Association\AlumniActivity\Http;

use DateTimeImmutable;
use Francken\Association\AlumniActivity\Alumnus;
use Francken\Association\FranckenVrij\Http\Requests\AdminSearchSubscriptionsRequest;
use Francken\Association\FranckenVrij\Subscription;
use Francken\Association\LegacyMember;
use Francken\Shared\Clock\Clock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class AlumniActivityController
{
    public function index() : View
    {
        $alumni = Alumnus::orderBy('fullname', 'asc')->get();

        return view('association.alumni-activity.index', [
            'alumni' => $alumni,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => action([self::class, 'index']), 'text' => 'Alumni activity 2022'],
            ]
        ]);
    }
}
