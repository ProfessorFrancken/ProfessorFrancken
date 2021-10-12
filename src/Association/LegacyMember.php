<?php

declare(strict_types=1);

namespace Francken\Association;

use DateTimeImmutable;
use Francken\Association\FranckenVrij\Subscription;
use Francken\Association\Members\Address;
use Francken\Association\Members\Events\MemberAddressWasChanged;
use Francken\Association\Members\Events\MemberEmailWasChanged;
use Francken\Association\Members\Events\MemberPaymentDetailsWereChanged;
use Francken\Association\Members\Events\MemberPhoneNumberWasChanged;
use Francken\Association\Members\Gender;
use Francken\Association\Members\PaymentDetails;
use Francken\Association\Members\StudyDetails;
use Francken\Auth\Account;
use Francken\Shared\Email;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
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
 * @property bool|null $mailinglist_email
 * @property bool|null $mailinglist_post
 * @property bool|null $mailinglist_sms
 * @property bool|null $mailinglist_constitutiekaart
 * @property bool|null $mailinglist_franckenvrij
 * @property int|null $erelid
 * @property string|null $notities
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \Francken\Association\Members\Address|null $address
 * @property-read \DateTimeImmutable|null $birthdate
 * @property-read \Francken\Association\Members\Email $email
 * @property-read string $firstname
 * @property-read string $fullname
 * @property-read string $gender
 * @property-read string $initials
 * @property-read \Francken\Association\Members\PaymentDetails $payment_details
 * @property-read string $phone_number
 * @property-read bool $receive_francken_vrij
 * @property-read bool $receive_newsletter
 * @property-read \Francken\Association\Members\Students\Student $student
 * @property-read string $student_number
 * @property-read string $surname
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\LegacyMember query()
 */
final class LegacyMember extends Model
{
    use SoftDeletes;

    protected $casts = [
        'mailinglist_email' => 'bool',
        'mailinglist_post' => 'bool',
        'mailinglist_sms' => 'bool',
        'mailinglist_constitutiekaart' => 'bool',
        'mailinglist_franckenvrij' => 'bool',
    ];

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

    public function getFullnameAttribute() : string
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
        return self::query()
            ->when(
                $except !== null && $except->isNotEmpty(),
                fn ($query) => $query->whereNotIn('id', $except)
            )
            ->where('is_lid', true)
            ->select(['id',  'voornaam', 'tussenvoegsel', 'achternaam'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn (LegacyMember $member) => [
                'label' => $member->fullname,
                'value' => $member->id
            ]);
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
        return new Email($this->emailadres ?? '');
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

        return new Address(
            $this->plaats ?? 'unknown',
            $this->postcode ?? 'unknown',
            $this->adres ?? 'unknown',
            $this->land ?? 'unknown'
        );
    }

    public function getPhoneNumberAttribute() : string
    {
        return $this->telefoonnummer_mobiel ?? '';
    }

    public function getStudentNumberAttribute() : string
    {
        return $this->studentnummer ?? '';
    }

    public function getStudentAttribute() : StudyDetails
    {
        return StudyDetails::fromDb($this);
    }

    public function getPaymentDetailsAttribute() : PaymentDetails
    {
        return PaymentDetails::fromDb($this);
    }

    public function getReceiveNewsletterAttribute() : bool
    {
        return (bool)$this->mailinglist_email;
    }

    public function getReceiveFranckenVrijAttribute() : bool
    {
        return (bool)$this->mailinglist_franckenvrij;
    }

    public function changeEmail(Email $email, bool $mailinglistMail) : void
    {
        $oldEmail = $this->email;
        $oldMailinglistMail = $this->mailinglist_email;
        $updateNewsletterSubscription = $oldMailinglistMail !== $mailinglistMail;

        if ($oldEmail == $email && ( ! $updateNewsletterSubscription)) {
            return;
        }

        $this->emailadres = $email->toString();
        $this->mailinglist_email = $mailinglistMail;
        $this->save();

        $account = Account::ofMember($this->id)->first();
        if ($account) {
            $account->email = $email->toString();
            $account->save();
        }

        event(new MemberEmailWasChanged($this, $email, $oldEmail, $updateNewsletterSubscription));
    }

    public function changeAddress(Address $address) : void
    {
        $oldAddress = $this->address;

        if ($oldAddress == $address) {
            return;
        }

        $this->plaats = $address->city();
        $this->land = $address->country();
        $this->adres = $address->address();
        $this->postcode = $address->postalCode();
        $this->save();

        event(new MemberAddressWasChanged($this, $address, $oldAddress));
    }

    public function changePhoneNumber(string $phoneNumber) : void
    {
        $oldPhoneNumber = $this->telefoonnummer_mobiel;

        if ($oldPhoneNumber === $phoneNumber) {
            return;
        }

        $this->telefoonnummer_mobiel = $phoneNumber;
        $this->save();

        event(new MemberPhoneNumberWasChanged($this, $phoneNumber, $oldPhoneNumber));
    }

    public function changePaymentDetails(PaymentDetails $paymentDetails) : void
    {
        $oldIban = $this->rekeningnummer;
        $oldConsumptionCounter = $this->streeplijst ?? 'Non-actief';
        $consumptionCounter = $paymentDetails->deductAdditionalCosts() ? "Afschrijven" : "Non-actief";
        $iban = $paymentDetails->iban();

        if ($oldIban === $iban && $oldConsumptionCounter == $consumptionCounter) {
            return;
        }

        $this->rekeningnummer = $iban;
        $this->streeplijst = $consumptionCounter;
        $this->save();

        event(
            new MemberPaymentDetailsWereChanged(
                $this,
                $iban,
                $oldIban,
                $consumptionCounter,
                $oldConsumptionCounter
            )
        );
    }

    public function franckenVrijSubscription() : HasOne
    {
        return $this->setConnection(config('database.default'))
            ->hasOne(Subscription::class, 'member_id')
            ->withDefault([
                'subscription_ends_at' => null
            ]);
    }

    public function getNotesAttribute() : ?string
    {
        return $this->notities;
    }
}
