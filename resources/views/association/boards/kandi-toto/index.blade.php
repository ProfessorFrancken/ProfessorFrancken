@extends('layout.two-column-layout')

@section('title', "Kandi toto - T.F.V. 'Professor Francken'")

@section('content')
    <h1 class="section-header">Kandi Toto {{ $boardYear->toString() }}</h1>


    @if ($bet === null)
        <p>
            Fill in the form below to take part of the Kandi Toto {{ $boardYear->toString() }}.
            For each correct candidate (including first and family name) you will receive <strong>one</strong> point; for the right candidate <em>and</em> correct position you will receive <strong>five</strong> points. The person with most points will receive a bottle of <strong>Hooghoudt Jonge Dubbele Graan&shy;jenever</strong> and, more importantly, <strong>eternal fame</strong>.
        </p>
        <div class="card">
            <div class="card-body">
                <x-forms.form url="{{ action([Francken\Association\Boards\Http\Controllers\KandiTotoController::class, 'store']) }}">
                    <x-forms.text name="president" label="Who will be <strong>president</strong>?" />
                    <x-forms.text name="secretary" label="Who will be <strong>secretary</strong>?" />
                    <x-forms.text name="treasurer" label="Who will be <strong>treasurer</strong>?" />
                    <x-forms.text name="intern" label="Who will be <strong>commissioner of internal relations</strong>?" />
                    <x-forms.text name="extern" label="Who will be <strong>commissioner of external relations</strong>?" />
                    <x-forms.text name="wildcard" label="Who will your <strong>wildcard</strong>?" />
                    <x-forms.submit text="Submit" />
                </x-forms.form>
            </div>
        </div>
    @else
        <p class="lead">
            Your submission for the Kandi Toto {{ $boardYear->toString() }} was:
        </p>
        <div class="card">
            <div class="card-body">
                <dl>
                    <dt>President</dt>
                    <dd>
                        {{ $bet->president }}

                </dd>
                <dt>Secretary</dt>
                <dd>
                    {{ $bet->secretary }}

                </dd>
                <dt>Treasurer</dt>
                <dd>
                    {{ $bet->treasurer }}
                </dd>
                <dt>commissioner of internal relations</dt>
                <dd>
                    {{ $bet->intern }}
                </dd>
                <dt>commissioner of external relations</dt>
                <dd>
                    {{ $bet->extern }}
                </dd>
                <dt>Your wildcard was</dt>
                @if ($bet->wildcard !== '')
                    <dd>
                        {{ $bet->wildcard }}
                    </dd>
                @else
                    <dd>You did not fill in any wildcard</dd>
                @endif
            </dl>
        </div>
    </div>
    @endif
    <p class=" text-muted mt-3">
        <small>
            By submitting this form you aggree to put in approximately one euro for a bottle of jenever for the winner. The toto closes when the applications close. Any interference with the application procedure with the aim of getting your candidates on the candidate board is allowed. Gambling is also allowed, because let's face it: noe one can keep those sjaar apart.
            This idea has been carried out particularly moderatly by <a href="mailto:boerma@professorfrancken.nl">Boerma</a> and was improved by Mark.
        </small>
    </p>
@endsection

@section('aside')
    <h2>Eternal fame</h2>
    <ul>
        <li class="my-3"><strong>2012</strong> &dash; dhr. Bosch </li>
        <li class="my-3"><strong>2013</strong> &dash; dhr. Bosch </li>
        <li class="my-3"><strong>2014</strong> &dash; dhr. Meesters and dhr Steensma </li>
        <li class="my-3"><strong>2015</strong> &dash; ir. Boerma </li>
        <li class="my-3"><strong>2016</strong> &dash; drs. Dam </li>
        <li class="my-3"><strong>2017</strong> &dash; dhr. Groen </li>
        <li class="my-3"><strong>2018</strong> &dash; mevr. Zwanenburg </li>
        <li class="my-3"><strong>2019</strong> &dash; dhr. F. Wobben, mej. Kamps, dhr. Redeman, mej. Kenbeek and ir. Boerma</li>
        <li class="my-3"><strong>2020</strong> &dash; dhr. Trustam and ir. Boerma </li>
        <li class="my-3"><strong>2021</strong> &dash; mevr. Anna Kenbeek <img src="https://upload.wikimedia.org/wikipedia/en/5/52/Kabouter_Wesley.jpg" width="50px"/> </li>
    </ul>
@endsection
