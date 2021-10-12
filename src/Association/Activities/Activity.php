<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Carbon\Carbon;
use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webmozart\Assert\Assert;

final class Activity extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'association_activities';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'summary',
        'source_content',
        'compiled_content',
        'location',
        'start_date',
        'end_date',
        'google_calendar_uid',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getGoogleMapsEmbedUriAttribute() : string
    {
        return 'https://www.google.com/maps/embed/v1/place?' . http_build_query([
            'q' => $this->location,
            'zoom' => 13,
            'key' => 'AIzaSyBmxy9LR0IeIDPmfVY_2ZQOLSbgNz_jDpw'
        ]);
    }

    public function getRegistrationDeadlineAttribute() : Carbon
    {
        if ($this->signUpSettings !== null) {
            return $this->signUpSettings->deadline_at;
        }

        return $this->end_date;
    }

    public function scopeAfter(Builder $query, DateTimeImmutable $date) : Builder
    {
        return $query->where('end_date', '>', $date);
    }

    public function getScheduleAttribute() : string
    {
        $string = '';
        $from = $this->start_date;
        $to = $this->end_date;
        $start = $this->start_date;
        $end = $this->end_date;

        $string .= $start->format('d');

        // Display month and year only twice if necessary
        if ($from->month !== $to->month) {
            $string .= $start->format(' F');
        }

        // Check if the end date is different
        if ($from->format('Y-m-d') !== $to->format('Y-m-d')) {
            $string .= ' - ' . $end->format('d F');
        } else {
            $string .= $end->format(' F');
        }

        // Show time if the activity isn't on the whole day
        if ($this->start_date->format('H:i') !== '00:00') {
            $string .= ' at ' . $start->format('H:i');
        }

        return $string;
    }

    public function signUpSettings() : HasOne
    {
        return $this->hasOne(SignUpSettings::class);
    }

    public function signUps() : HasMany
    {
        return $this->hasMany(SignUp::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getTotalSignUpsAttribute() : int
    {
        return $this->signUps
                ->map(fn (SignUp $signUp) : int => 1 + (int)$signUp->plus_ones)
                ->sum();
    }

    public function memberCanSignUp(LegacyMember $member) : bool
    {
        $deadlineAt = $this->registration_deadline;

        if ($deadlineAt->isPast()) {
            return false;
        }

        if ($this->signUpSettings === null) {
            return false;
        }

        if ($this->signUpSettings->max_sign_ups !== null && $this->total_sign_ups >= $this->signUpSettings->max_sign_ups) {
            return false;
        }

        return ! $this->signUps->pluck('member_id')->contains($member->id);
    }

    public function signUp(
        LegacyMember $member,
        int $plusOnes = 0,
        string $dietaryWishes = '',
        bool $hasDriversLicense = false
    ) : void {
        Assert::true($this->memberCanSignUp($member));

        $this->signUps()->save(
            new SignUp([
                'member_id' => $member->id,
                'plus_ones' => $plusOnes,
                'dietary_wishes' => $dietaryWishes,
                'has_drivers_license' => $hasDriversLicense,
                'notes' => ''
            ])
        );
    }
}
