<div class="card my-3">
    <div class="card-header">
        <h3>Personal Information</h3>
    </div>

    <div class="card-body">
        <ul>
            <li>Picture</li>
            <li>Firstname, lastname: {{ $profile->full_name }}</li>
            <li>Mother Tongue: {{ $profile->land }}</li>
            <li>Birthdate: {{ $profile->geboortedatum }}</li>
            <li>Gender: {{ $profile->geslacht }}</li>
        </ul>
    </div>
</div>

<div class="card my-3">
    <div class="card-header">
        <h4>Contact details</h4>
    </div>
    <div class="card-body">
        <ul>
            <li>Email: {{ $profile->emailadres }}</li>
            <li>Address {{ $profile->plaats }}, {{ $profile->postcode }}, {{ $profile->adres }}</li>
        </ul>
    </div>
</div>
