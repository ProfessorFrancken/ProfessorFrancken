<?php

declare(strict_types=1);

namespace Francken\Association;

use DateTimeImmutable;
use DB;
use Francken\Association\Members\Address;
use Francken\Association\Members\Email;
use Francken\Association\Members\Gender;
use Francken\Association\Members\PaymentDetails;
use Francken\Association\Members\Students\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Francken\Association\LegacyMember
 *
 * @property int $id
 * @property string|null $geslacht
 * @property string|null $titel
 * @property string|null $initialen
 * @property string|null $voornaam
 * @property string|null $tussenvoegsel
 * @property string $achternaam
 * @property string|null $geboortedatum
 * @property string|null $foto
 * @property int|null $nederlands
 * @property string|null $adres
 * @property string|null $postcode
 * @property string|null $plaats
 * @property string|null $land
 * @property int|null $is_nederland
 * @property string|null $emailadres
 * @property string|null $telefoonnummer_thuis
 * @property string|null $telefoonnummer_werk
 * @property string|null $telefoonnummer_mobiel
 * @property string|null $rekeningnummer
 * @property string|null $plaats_bank
 * @property int|null $machtiging
 * @property int|null $wanbetaler
 * @property int|null $gratis_lidmaatschap
 * @property string|null $start_lidmaatschap
 * @property string|null $einde_lidmaatschap
 * @property int|null $is_lid
 * @property string|null $type_lid
 * @property string|null $studentnummer
 * @property string|null $studierichting
 * @property string|null $jaar_van_inschrijving
 * @property string|null $afstudeerplek
 * @property int|null $afgestudeerd
 * @property string|null $werkgever
 * @property string|null $nnvnummer
 * @property string|null $streeplijst
 * @property int|null $mailinglist_email
 * @property int|null $mailinglist_post
 * @property int|null $mailinglist_sms
 * @property int|null $mailinglist_constitutiekaart
 * @property int|null $mailinglist_franckenvrij
 * @property int|null $erelid
 * @property string|null $notities
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $full_name
 * @property-read mixed $surname
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereAchternaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereAdres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereAfgestudeerd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereAfstudeerplek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereEindeLidmaatschap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereEmailadres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereErelid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereGeboortedatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereGeslacht($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereGratisLidmaatschap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereInitialen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereIsLid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereIsNederland($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereJaarVanInschrijving($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereLand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereMachtiging($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereMailinglistConstitutiekaart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereMailinglistEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereMailinglistFranckenvrij($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereMailinglistPost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereMailinglistSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereNederlands($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereNnvnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereNotities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember wherePlaats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember wherePlaatsBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereRekeningnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereStartLidmaatschap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereStreeplijst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereStudentnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereStudierichting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereTelefoonnummerMobiel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereTelefoonnummerThuis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereTelefoonnummerWerk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereTussenvoegsel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereTypeLid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereVoornaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereWanbetaler($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember whereWerkgever($value)
 * @mixin \Eloquent
 */
final class LegacyMember extends Model
{
    /**
     * @var string
     */
    protected $table = 'leden';

    /**
     * @var string
     */
    protected $connection = 'francken-legacy';

    /**
     * @var mixed[]
     */
    protected $guarded = [];

    public function getFullNameAttribute() : string
    {
        return collect([
            $this->voornaam,
            $this->tussenvoegsel,
            $this->achternaam
        ])->filter()->implode(' ');
    }

    public function getFirstnameAttribute() : string
    {
        return $this->voornaam ?? '';
    }

    public function getSurnameAttribute() : string
    {
        return collect([$this->tussenvoegsel, $this->achternaam])->filter()->implode(' ');
    }

    public static function autocomplete(Collection $except = null) : Collection
    {
        $query = DB::connection('francken-legacy')
            ->table('leden');

        if ($except !== null && $except->isNotEmpty()) {
            $query = $query->whereNotIn('id', $except);
        }

        return $query
            ->where('is_lid', true)
            ->select(['id',  'voornaam', 'tussenvoegsel', 'achternaam'])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function getInitialsAttribute() : string
    {
        return $this->initialen ?? '';
    }

    public function getGenderAttribute() : string
    {
        if ($this->geslacht === 'V') {
            return Gender::FEMALE;
        }

        if ($this->geslacht === 'M') {
            return Gender::MALE;
        }

        return $this->geslacht ?? '';
    }

    public function getBirthdateAttribute() : ?DateTimeImmutable
    {
        if ($this->geboortedatum === null) {
            return null;
        }

        $birthdate = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->geboortedatum
        );

        if ( ! ($birthdate instanceof DateTimeImmutable)) {
            return null;
        }

        return $birthdate;
    }

    public function getEmailAttribute() : Email
    {
        return new Email($this->emailadres);
    }

    public function getAddressAttribute() : ?Address
    {
        if ($this->plaats && $this->postcode && $this->adres && $this->land) {
            return new Address(
                $this->plaats,
                $this->postcode,
                $this->adres,
                $this->land
            );
        }

        return null;
    }

    public function getPhoneNumberAttribute() : string
    {
        return $this->telefoonnummer_mobiel ?? '';
    }

    public function getStudentNumberAttribute() : string
    {
        return $this->studentnummer ?? '';
    }

    public function getStudentAttribute() : Student
    {
        return Student::fromDb($this);
    }

    public function getPaymentDetailsAttribute() : PaymentDetails
    {
        return PaymentDetails::fromDb($this);
    }
}
