@section('description')
‘Professor Francken’ is the study association for Applied Physics, connected to the University of Groningen. It is named after Groningen’s first professor of Applied Physics and is for students and staff of the applied physics departments. It has over 700 members and organizes, among other, field trips in the Netherlands and an annual symposium and a foreign excursion. Various activities, including the introductory activities for first-year students and the Bèta-bedrijvendagen (a career event for science students), are organised in partnership with sister associations. Membership is a must for students with a technical orientation.
@endsection

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', "T.F.V. 'Professor Francken'")</title>
    <meta name="description" content="@yield('description')" />

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/home.css" rel="stylesheet">
    <link href="/css/menu.css" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

    @stack('css')
</head>
