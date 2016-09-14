@extends('admin.layout')

@section('content')
    <h1>Membership submissal of Mark Redeman</h1>

    <section>
        <h3>
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            Personal info
        </h3>
        <dl class="dl-horizontal">
            <dt>Firstname<dt>
            <dd>Mark</dd>

            <dt>Lastname<dt>
            <dd>Redeman</dd>

            <dt>Gender<dt>
            <dd>
                <i class="fa fa-male" aria-hidden="true"></i>
                Male
            </dd>

            <dt>Mothertongue<dt>
            <dd>Dutch</dd>
        </dl>

        <hr/>
    </section>

    <section>
        <h3>
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            Contact details
        </h3>

        <dl class="dl-horizontal">
            <dt>Email<dt>
            <dd>
                <a href="mailto:markredeman@gmail.com">
                    markredeman@gmail.com
                </a>
            </dd>

            <dt>Zip-code<dt>
            <dd>1234as</dd>

            <dt>City<dt>
            <dd>Groningen</dd>

            <dt>Address</dt>
            <dd>Neijenborgh 9</dd>
        </dl>

        <hr/>
    </section>

    <section>
        <h3>
            <i class="fa fa-check-circle-o" aria-hidden="true"></i>
            Study details
        </h3>

        <dl class="dl-horizontal">
            <dt>Study<dt>
            <dd>
                Applied Mathematics
            </dd>

            <dt>Student number<dt>
            <dd>12345678</dd>

            <dt>Starting date study<dt>
            <dd>01-09-2010</dd>
        </dl>

        <hr/>
    </section>


    <section>
        <h3>
            <i class="fa fa-circle-o" aria-hidden="true"></i>
            Membership payment
        </h3>
        <p class="alert alert-warning">
            The student's <strong>ISBN</strong> has not yet been provided.
        </p>

        <dl class="dl-horizontal">
            <dt>ISBN</dt>
            <dd>
                <p class="text-warning">
                    Not yet provided
                </p>
            </dd>

            <dt>Membership fee</dt>
            <dd>
                <i class="fa fa-check" aria-hidden="true"></i>
            </dd>

            <dt>Streepsysteem</dt>
            <dd>
            </dd>
        </dl>

        <hr/>
    </section>

    <section>
        <h3>Activity</h3>

        <ul>
            <li>Yesterday - updated personal info</li>
            <li>Last thursday - confirmation email send to Mark Redeman</li>
            <li>Last thursday - notification email send to Board</li>
            <li>Last thursday - registration request submitted</li>
        </ul>

        <hr/>
    </section>

    <section>
        <h3>Complete registration</h3>

        <p>
            The following fields have not yet been provided.
            You can choose to omit these fields (i.e. we will use the defautl values listed below).
            It is required to leave a reason why these fields heave been omitted.
        </p>

        <form>
            <div class="form-group">
                <label for="isbn" class="control-label">Isbn</label>
                <input class="form-control" name="isbn" id="isbn">
            </div>

            <div class="form-group">
                <label for="reason" class="control-label">Reason</label>
                <textarea class="form-control" name="reason" id="reason" rows="3" placeholder="Student does not yet have a ISBN"></textarea>
            </div>

            <div class="btn btn-success btn-block btn-lg">
                Complete registration
            </div>
        </form>
    </section>
@endsection
