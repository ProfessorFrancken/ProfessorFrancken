<div class="row mt-4">
    <div class="col">
        <x-forms.text name="firstname" label="Firstname" />
        <x-forms.text name="lastname" label="Lastname" />
        <x-forms.email name="email" label="Email" />
    </div>
    <div class="col-12 col-md-6">
        <x-forms.checkbox name="is_nnv_member" label='Is nnv member' />
        <x-forms.text name="nnv_number" label="NNV number" />

        <x-forms.checkbox name="is_francken_member" label='Is Francken member' />
        <x-forms.text name="member_id" label="Francken member id" />

        <x-forms.checkbox name="pays_with_iban" label='Pays with iban' />
        <x-forms.text name="iban" label="Iban" :value="$participant->iban ? decrypt($participant->iban) : ''" />

        <x-forms.checkbox name="free_lunch" label='Free lunch' />
        <x-forms.checkbox name="free_borrelbox" label='Free borrelbox' />
    </div>
</div>
