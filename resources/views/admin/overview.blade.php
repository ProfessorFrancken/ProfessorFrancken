@extends('admin.layout')
@section('page-title', 'Administration panel')

@section('content')
    <p class="lead">
        Welcome to the administration page of T.F.V. 'Professor Francken'.
        Currently only board members are allowed to use these pages. If you're not a board member, you're probably lost.
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
@endsection
