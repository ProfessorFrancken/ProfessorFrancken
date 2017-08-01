@extends('admin.layout')

@section('content')
    <h1 class="section-header">
        Administration panel
    </h1>

    <p class="lead">
        Welcome to the administration page of T.F.V. 'Professor Francken'.
        Currently only board memers are allowed to use these pages. If you're not a board member, you're probably lost.
        At some point committee members will be allowed access to these pages so that they can do their committee member business and not bother the board with their tedious and often boring tasks (Digital Anarchy ftw).
    </p>

    <p class="lead">
        As you might have noticed these admin pages lack much functionallity (all menu items that have a <i class="fa fa-times" aria-hidden="true"></i> icon in front of it are currently disabled). Over time more functionallity will be added and the use of our old database system should no longer be necessary. The following is a prioritized list of stuff that will be added.
    </p>

    <ol>
        <li>Publishing and maintaining Francken Vrij</li>
        <li>Managing committees and their members</li>
        <li>Selling and buying books</li>
        <li>Managing memberships</li>
        <li>Customer Relationship Management (e.g. doing company stuff)</li>
        <li>Streepsysteem 2.0</li>
    </ol>

    <hr/>

    <h3>
        Latest events
    </h3>

    <p>
        You can use this table to quickly find out whether anything has changed on our website.
        Currently it does't show a lot of information and the event names are quite cryptic.
        At some point I would like to improve the naming of the events, show the person responsible for the event and possibly add a link to any relevant admin pages for the event.
    </p>

    <table class="table table-hover table-sm">
        <thead class="thead-inverse">
            <tr>
                <th>Occured on</th>
                <th>Event name</th>
            </tr>
        </thead>
        @foreach ($events as $event)
            <tr>
                <td>{{ (new DateTimeImmutable($event->recorded_on))->format('d F Y - h:m:s') }}</td>
                <td>{{ $event->type }}</td>
            </tr>
        @endforeach
    </table>

    </div>
@endsection
