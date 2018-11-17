<?php

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\DateTime;
use Broadway\Serializer\Serializer as SerializerInterface;
use Francken\Domain\Members\Study;

$serializer = app(SerializerInterface::class);
$events     = DB::table('event_store')->get();

$deserialize = function ($json) use ($serializer) {
    return $serializer->deserialize(
        json_decode($json, true)
    );
};

$stream =// new DomainEventStream(
    $events->map(
        function ($event) use ($deserialize) {
            return new DomainMessage(
                $event->uuid,
                (int) $event->playhead,
                $deserialize($event->metadata),
                $deserialize($event->payload),
                DateTime::fromString(
                    $event->recorded_on
                )
            );
        },
        $events
    )->toArray();//);

$state = [];
$projection = function (array $state, DomainMessage $message) {
    $event = $message->getPayload();
    switch (get_class($event)) {
        case \Francken\Domain\Members\Registration\Events\PaymentInfoProvided::class:
            try {
                $info = $event->paymentInfo();
                $id = (string)$event->registrationRequestId();

                $state[$id]['pay_for_membership'] = $info->payForMembership();
                $state[$id]['pay_for_drinks'] = $info->payForFoodAndDrinks();
                $state[$id]['iban'] = $info->iban();

                return $state;
            } catch (\Exception $e) {
                return $state;
            }
        case \Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted::class:
            try {
                $studies = array_map(function (Study $study) {
                    return $study;
                    return [
                        'name' => $study->study(),
                        'start_date' => $study->startDate(),
                        'graduation_date' => $study->graduationDate(),
                    ];
                }, $event->studies());
            } catch (\TypeError $e) {
                $studies = [];
            }

            try {
                $email = (string)$event->email();
            } catch (\TypeError $e) {
                $email = '';
            }

            try {
                $address = $event->address();
                $address = "{$address->city()} {$address->postalCode()} {$address->address()}";
            } catch (\TypeError $e) {
                $address = '';
            }

            try {
                $birthdate = $event->birthdate();
            } catch (\TypeError $e) {
                var_dump($event);
                throw $e;
            }

            $data = [
                'id' => (string)$event->registrationRequestId(),
                'name' => $event->fullName()->fullName(),
                'gender' => (string)$event->gender(),
                'birthdate' => $event->birthdate()->format('Y-m-d'),
                'studentNumber' => $event->studentNumber(),
                'email' => $email,
                'address' => $address,
                'registered_at' => $message->getRecordedOn()->toString(),
            ];

            for ($idx = 0; $idx < count($studies); $idx++) {
//                $data['studies_'.$idx] = $studies[$idx];
                $data['studies_'.$idx.'_name'] = $studies[$idx]->study();
                $data['studies_'.$idx.'_start_date'] = $studies[$idx]->startDate()->format('Y-m-d');
                $data['studies_'.$idx.'_graduation_date'] = $studies[$idx]->graduationDate();
            }

            return array_merge([(string)$event->registrationRequestId() => $data], $state);
    }

    return $state;
};

array_reduce($stream, $projection, []);
