<h5>Personal details</h5>
<div class="row">
    <div class="col col-md-4">
        <h6>
            Membership
        </h6>

        <x-forms.date name="start_lidmaatschap" label="Start membership" />
        <x-forms.date name="einde_lidmaatschap" label="End membership" />
        <x-forms.checkbox name="is_lid" label="Has active membership" />
        <x-forms.select name="type_lid" label="Member type" :options="$memberTypeOptions" />
        <x-forms.checkbox name="erelid" label="Is member of honors" />
    </div>
    <div class="col col-md-4">
        <h6>
            Name
        </h6>
        <x-forms.text name="initialen" label="Initials" />
        <x-forms.text name="titel" label="Title" />
        <x-forms.text name="voornaam" label="Firstname" />
        <x-forms.text name="tussenvoegsel" label="Insertion (tussenvoegsel)" />
        <x-forms.text name="achternaam" label="Surname" />
    </div>
    <div class="col col-md-4">
        <h6>
            Birthdate & gender
        </h6>
        <x-forms.date name="geboortedatum" label="Birthdate" />
        <div class="d-flex flex-column flex-sm-row align-items-start mt-2">
            <div class="form-check mr-3">
                {!!
                       Form::radio(
                           'gender',
                           'female',
                           false,
                           [
                               'id' => 'gender-female',
                               'class' => 'form-check-input',
                               'required',
                           ]
                       )
                !!}
                <label class="form-check-label" for='gender-female'>
                    Female
                </label>
            </div>

            <div class="form-check mr-3">
                {!!
                       Form::radio(
                           'gender',
                           'male',
                           false,
                           [
                               'id' => 'gender-male',
                               'class' => 'form-check-input'
                           ]
                       )
                !!}
                <label class="form-check-label mr-3" for='gender-male'>
                    Male
                </label>
            </div>

            <div class="d-flex flex-column">
                <div class="form-check">
                    {!!
                           Form::radio(
                               'gender',
                               'other',
                               true,
                               [
                                   'id' => 'gender-other',
                                   'class' => 'mr-2 form-check-input',
                                   'checked' => !in_array($member->geslacht, ['M', 'V'])
                               ]
                           )
                    !!}

                    <label class="form-check-label flex-grow-1 d-flex justify-content-between align-items-center" for='gender-other'>
                        Other / prefer not to share
                    </label>
                </div>
                <div class="mt-2">
                    {!!
                           Form::text(
                               'other_gender',
                               in_array($member->geslacht, ['M', 'V']) ? null : $member->geslacht,
                               [
                                   'placeholder' => "Other",
                                   'class' => 'form-control',
                               ]
                           )
                    !!}
                </div>
            </div>
        </div>

        <div class="form-group">
            Gender
            
        </div>
        <h6>
            Nationality & language
        </h6>
        <x-forms.checkbox name="nederlands" label="Knows Dutch" />
        <x-forms.checkbox name="is_nederland" label="Has Dutch nationality" />
    </div>
</div>




<div class="row mt-4">
    <div class="col col-md-4">
        <h6>Contact details</h6>
        <x-forms.email name="emailadres" placeholder="email@example.com">
            <x-slot name="label">
                <i class="fas fa-fw fa-envelope-open-text text-primary"></i>
                Email
            </x-slot>
        </x-forms.email>

        <x-forms.text name="telefoonnummer_mobiel" placeholder="+31 50 363 4978">
            <x-slot name="label">
                <i class="fas fa-fw fa-mobile text-primary"></i>
                Phone number
            </x-slot>
        </x-forms.text>
    </div>

    <div class="col col-md-4">
        <h6>
            <i class="fas fa-fw fa-map-marker-alt"></i> Address
        </h6>
        <x-forms.text name="plaats" label="City" placeholder="Groningen" />
        <x-forms.text name="adres" label="Address" placeholder="Nijenborgh 9" />
        <x-forms.text name="postcode" label="Postal code" placeholder="9742 AG" />
        <x-forms.text name="land" label="Country" placeholder="Netherlands" />
    </div>

    <div class="col col-md-4">
        <h6>
            <i class="fas fa-fw fa-mail-bulk"></i>
            Mailinglist
        </h6>
        <x-forms.checkbox name="mailinglist_email" label="Mailinglist email" />
        <x-forms.checkbox name="mailinglist_post" label="Mailinglist post" />
        <x-forms.checkbox name="mailinglist_sms" label="Mailinglist sms" />
        <x-forms.checkbox name="mailinglist_constitutiekaart" label="Mailinglist constitutional card" />
        <x-forms.checkbox name="mailinglist_franckenvrij" label="Mailinglist Francken Vrij" />
    </div>
</div>


<div class="row mt-4">
    <div class="col col-md-4">
        <h6>Finance</h6>
        <x-forms.text name="rekeningnummer" label="Iban" />
        <x-forms.text name="plaats_bank" label="Bank location" />
        <x-forms.checkbox name="machtiging" label="Debit authorization" />
        <x-forms.checkbox name="wanbetaler" label="Defaulter (Wanbetaler)" />
        <x-forms.checkbox name="gratis_lidmaatschap" label="Free membership" />
        <x-forms.select name="streeplijst" label="Consumption counter payment method" :options="$consumptionCounterOptions"/>
        
    </div>
    <div class="col col-md-4">
        <h6>Studies</h6>
        <x-forms.text name="studentnummer" label="Studentnumber" />
        <x-forms.text name="studierichting" label="Study" />
        <x-forms.text name="jaar_van_inschrijving" label="Year of registration" />
        <x-forms.text name="afstudeerplek" label="Place of graduation" />
        <x-forms.checkbox name="afgestudeerd" label="Graduated" />
    </div>
    
    <div class="col col-md-4">

        <h6>Ohter</h6>
        <x-forms.text name="werkgever" label="Employer" />
        <x-forms.text name="nnvnummer" label="NNV Number" />
        <x-forms.textarea name="notities" label="Notes" />
    </div>
</div>

