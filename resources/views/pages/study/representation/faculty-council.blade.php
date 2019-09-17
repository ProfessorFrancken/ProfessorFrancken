@extends('pages.study')
@section('title', "Faculty Council - T.F.V. 'Professor Francken'")
@php
$breadcrumbs = [
    ['url' => '/study', 'text' => 'Study'],
    ['text' => 'Faculty council'],
];
@endphp

@section('content')
    <h1 class="section-header">
        Faculty Council
    </h1>
    <p class="text-justify">
        The faculty council is a participation body that consists of nine elected students and nine staff members of the faculty. The students are elected for one year and the staff-members for 2 years. As a Faculty Council we have the right of consent on certain topics to the Faculty Board and are allowed to share our advice and feelings on other topics, in this way we are directly involved in the process of decision making at our Faculty.
    </p>
    <div class="row">
          <div class="col-md-6">
                <h2>
                Faculty Council Cycles
            </h2>
                <p>
                During the academic year we have 7 cycles of 6 weeks in which we have different meetings. Every cycle there are meetings from the different committees and meetings with the council. We meet three times during a cycle with the student faction, usually on Friday afternoons. In those meetings we discuss the incoming and outgoing mail from the faculty board, policy plans and other things that have come up. We also decide upon the subjects we want to ask questions to the board or what we need to investigate further. Additionally, we sometimes write a memo about topics, important for the student community, with suggestions on improvements for the faculty which we present to the board.
            </p>
                <p>
                On the final day of each cycle, we have three meetings: first one with the student faction, then one with the whole council (including staff) and finally one with the board. This day, all important topics are discussed and decided upon. Sometimes, we have to vote on certain issues when a consensus cannot be reached.
            </p>

            <div class="mb-3">
                    <a class="btn btn-secondary" href="http://student.portal.rug.nl/infonet/studenten/fse/quick-links/facraad/faculteitsraad/">
                    <i class="fa fa-globe mr-2" aria-hidden="true"></i>
                    Website
                </a>
                    <a class="btn btn-secondary" href="mailto:fast@betastuf.nl">
                    <i class="fa fa-envelope-o mr-2" aria-hidden="true"></i>
                    fast@betastuf.nl
                </a>
                    <a class="btn btn-secondary" href="https://www.facebook.com/fcfse/">
                        <i class="fa fa-facebook mr-2" aria-hidden="true"></i>
                    Facebook
                    </a>
            </div>
          </div>

          <div class="col-md-6">
                <h2>
                Faculty Council Committees
            </h2>
                <p>
                There are different committees in the Faculty Council, each one of them consists of both student and staff members and they discuss various topics related to their focus on which they give updates during the council meetings with their faction. In this way all council members are well informed on all the topics we discuss. Not all committees meet as often or take as much time as others, but they are all important and every member of the Faculty Council takes place in 2 different committees.
            </p>

            <dl>
                <dt>
                        Research and Education Committee
                </dt>
                <dd>
                        This committee reviews everything that has to do with changes or improvements related to research and education, for example the Teaching and Examination Regulations.
                </dd>

                <dt>
                    Facilities Committee (FaZa)
                </dt>
                <dd>
                        The FaZa discusses all facility related things, for example the malfunctioning of the Bernoulliborg entrance, the outsourcing of the printing facilities, but also reports on safety and sustainability in the buildings at our faculty.
                </dd>

                <dt>
                    Financial Committee (FinCie)
                </dt>
                <dd>

                        The FinCie talks about the finances of the faculty in more detail with the board so they can inform the other council members and answer questions from their faction during the council meetings.
                </dd>


                <dt>
                    Communication Committee (ComCom)
                </dt>
                <dd>
                        The ComCom (among other things) is responsible for writing the Faculty Council newsletter, improving the visibility of the council and coordinating the elections.
                </dd>
                <dt>
                    Personnel and Organisation Committee (P&O)
                </dt>
                <dd>
                        The P&O focuses for example on changes in policy regarding the faculty staff and reports on workload among staff members.
                </dd>
            </dl>
          </div>
    </div>
@endsection
