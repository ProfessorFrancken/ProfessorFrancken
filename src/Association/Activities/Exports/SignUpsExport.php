<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Exports;

use Francken\Association\Activities\Activity;
use Francken\Association\Activities\SignUp;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SignUpsExport implements FromView, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    private Activity $activity;

    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
    }

    public function view() : View
    {
        $activity = $this->activity;

        return view('admin.association.activities.sign-ups.export', [
            'activity' => $activity,
            'totalCosts' => $activity->signUps->map(fn (SignUp $signUp) => $signUp->costs)->sum(),
            'signUps' => $activity->signUps->sortBy(fn (SignUp $signUp) => $signUp->member->achternaam)
        ]);
    }

    public function styles(Worksheet $sheet) : array
    {
        $signUpColumn = sprintf('B1:B%d', $this->activity->signUps->count() + 2 + 20);
        return [
            $signUpColumn => [
                'borders' => [
                    'right' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                    'left' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ]
            ],
            'A2:B2' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                    'bottom' => [
                        'borderStyle' => Border::BORDER_DOUBLE,
                        'color' => ['argb' => '00000000'],
                    ],
                ]
            ],

            // Style the first row as bold text.
            'A1'    => ['font' => ['bold' => true]],
            'B1'    => ['font' => ['bold' => true]],
            'C1'    => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats() : array
    {
        return [
            'B' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
            'D' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }
}
