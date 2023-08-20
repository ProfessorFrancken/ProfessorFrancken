<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 * @property-read mixed $fullname
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
final class BookSeller extends Model
{
    /**
     * @var string
     */
    protected $table = 'leden';

    /**
     * @var string
     */
    protected $connection = 'francken-legacy';

    public function getFullnameAttribute() : string
    {
        return collect([$this->voornaam, $this->tussenvoegsel, $this->achternaam])
            ->filter()
            ->implode(' ');
    }
}
