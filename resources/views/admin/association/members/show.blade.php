@extends('admin.layout')
@section('page-title', 'Members ' . ' / ' . $member->fullname)

    @section('content')
        <p class="lead">
            Work in progress
        </p>

        <div class="card">
            <div class="card-body">
                <ul>
                    <li>
                        Personal details
                        <ul>
                            <li>Name</li>
                            <li>Gender</li>
                            <li>Birthdate</li>
                            <li>Title</li>
                            <li>NNV number</li>
                        </ul>
                    </li>
                    <li>Contact details
                        <ul>
                            <li>Email</li>
                            <li>Address</li>
                            <li>Phonenumber</li>
                        </ul>
                    </li>
                    <li>Study
                        <ul>
                            <li>Books</li>                        
                        </ul>
                    </li>
                    <li>
                        Financial
                        <ul>
                            <li>Recent transactions</li>
                            <li>Consumption Counter settings</li>
                        </ul>
                    </li>
                    <li>Notes</li>

                    <li>
                        Association
                        <ul>
                            <li>Boar</li>
                            <li>Committees</li>
                            <li>Activities</li>
                            <li>Francken Vrij subscription</li>
                        </ul>
                    </li>
                    <li>
                        Career
                        <ul>
                            <li>Alumni</li>
                        </ul>
                    </li>
                    
                    <li>
                        Account
                        <ul>
                            <li>Roles</li>
                            <li>Permissions</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    @endsection
