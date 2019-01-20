@section('description')
‘Professor Francken’ is the study association for Applied Physics, connected to the University of Groningen. It is named after Groningen’s first professor of Applied Physics and is for students and staff of the applied physics departments. It has over 700 members and organizes, among other, field trips in the Netherlands and an annual symposium and a foreign excursion. Various activities, including the introductory activities for first-year students and the Bèta-bedrijvendagen (a career event for science students), are organised in partnership with sister associations. Membership is a must for students with a technical orientation.
@endsection

@section('keywords', 'Engineering Physics, Applied Physics, University of Groningen, Study Association, Research, Books, Second hand books, Beta, Career, Technische Natuurkunde, Tweedehands boeken')

<title>@yield('title', "T.F.V. 'Professor Francken' - the study association for engineering physics in Groningen")</title>
<meta name="description" content="@yield('description')" />
<meta name="keywords" content="@yield('keywords')" />

<meta property="og:site_name" content="T.F.V. 'Professor Francken' - the study association for engineering physics in Groningen">
<meta property="og:title" content="@yield('title', "T.F.V. 'Professor Francken'")">
<meta property="og:description" content="@yield('description')">
<meta property="og:url" content="https://professorfrancken.nl">
<meta property="og:type" content="website" />

<meta name="ICBM" content="53.238847, 6.537181">
<meta name="geo.position" content="53.238847;6.537181">
<meta name="geo.placename" content="Groningen">
