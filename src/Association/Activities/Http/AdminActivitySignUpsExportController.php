<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Exports\SignUpsExport;
use Francken\Association\Activities\SignUp;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class AdminActivitySignUpsExportController
{
    public function index(Activity $activity) : BinaryFileResponse //: BinaryFileResponse
    {
        $activity->load([
            'signUpSettings',
            'signUps.member',
            'signUps.activity.signUpSettings',
        ]);

        // return view('admin.association.activities.sign-ups.export', [
        //     'activity' => $activity,
        //     'totalCosts' => $activity->signUps->map(fn (SignUp $signUp) => $signUp->costs)->sum(),
        //     'signUps' => $activity->signUps->sortBy(fn (SignUp $signUp) => $signUp->member->achternaam)
        // ]);

        return Excel::download(
            new SignUpsExport($activity),
            sprintf("%s-sign-ups.xlsx", Str::slug($activity->name))
        );
    }
}
