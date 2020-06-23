<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Mail;

use Francken\Association\Symposium\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InformationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Participant
     */
    public $participant;

    public $theme = 'symposium';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(
            "Symposium May 8th '" . $this->participant->symposium->name . "'"
        )->markdown('symposium.mails.information', [
            'full_name' => $this->participant->full_name,
            'participant' => $this->participant,
            'location_url' => 'https://www.google.com/maps/dir/?api=1&destination=EM2+VENUE,+Suikerlaan,+Groningen&travelmode=bicycling',
            'schedule' => [
                [
                    'time' => '09:00',
                    'title' => 'Registration and Coffee',
                    'subTitle' => '',
                ],
                [
                    'time' => '09:25',
                    'title' => 'Word of welcome',
                    'subTitle' => 'Eva Visser',
                ],
                [
                    'time' => '09:30',
                    'title' => 'Opening',
                    'subTitle' => 'Prof. dr. ir. Bart Kooi',
                ],
                [
                    'time' => '09:45',
                    'title' => 'New materials for solar cells',
                    'subTitle' => 'Prof. Dr. Jan Anton Koster',
                ],
                [
                    'time' => '10:30',
                    'title' => 'Coffee break',
                    'subTitle' => '',
                ],
                [
                    'time' => '11:00',
                    'title' => 'Additive manufacturing',
                    'subTitle' => 'Dr. Thomas Pijper',
                ],
                [
                    'time' => '11:45',
                    'title' => 'Non equilibrium materials',
                    'subTitle' => 'Dr. Liesbeth Janssen',
                ],
                [
                    'time' => '12:30',
                    'title' => 'Lunch break',
                    'subTitle' => '',
                ],
                [
                    'time' => '13:40',
                    'title' => 'Si technology: innovative textile functionalization',
                    'subTitle' => 'Mário Brito',
                ],
                [
                    'time' => '14:25',
                    'title' => 'Large scale additive manufacturing with metals',
                    'subTitle' => 'ir. Bert van Haastrecht',
                ],
                [
                    'time' => '15:10',
                    'title' => 'Coffee break',
                    'subTitle' => '',
                ],
                [
                    'time' => '15:30',
                    'title' => 'Modeling of Rolling Contact Fatigue in Bearings',
                    'subTitle' => 'Yuri Kadin',
                ],
                [
                    'time' => '16:15',
                    'title' => 'Concluding remarks',
                    'subTitle' => 'Prof. dr. ir. Bart Kooi',
                ],
                [
                    'time' => '16:30',
                    'title' => 'Reception',
                    'subTitle' => '',
                ],
            ]
        ]);
    }
}
