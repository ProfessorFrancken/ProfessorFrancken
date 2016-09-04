@extends('base-layout')

@section('content')
    <h1>Contact</h1>

    <div class="row">
        <div class="col-sm-4">
            <h2>Address</h2>

            <address>
                <h4>Postadres</h4>
                T.F.V. ‘Professor Francken’<br>
                Nijenborgh 4<br>
                9747 AG Groningen
            </address>

            <address>
                <h4>Bezoekadres</h4>
                <strong>Bestuurskamer</strong>: gebouw 13, kamer 5113.0006<br>
                <strong>Ledenkamer</strong>: gebouw 13, kamer 5113.0002<br>
            </address>
        </div>
        <div class="col-sm-4">
            <h2>Contact details</h2>

            <h4>Bestuur</h4>
            <strong>Email</strong>: bestuur@professorfrancken.nl<br>
            <strong>Telefoon</strong>: +31 (0) 50 363 4978

            <h4>Bedrijvencommissaris</h4>
            <strong>Email</strong>: bedrijvencommissaris@professorfrancken.nl<br>
            <strong>Telefoon</strong>: +31 637349724
        </div>
        <div class="col-sm-4">
            <h2>Other information</h2>

            <strong>K.v.K.</strong>: 400 252 71<br>
            <strong>Bankrekeningnummer</strong>: NL31 ABNA 0510 5771 56
        </div>
    </div>


    <div class="well">
        <h3>Questions?</h3>
        <p>
            Do you have questions, or is your company interested in working with T.F.V. 'Professor Francken'?
        </p>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input class="form-control" name="name">
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" placeholder="example@gmail.com">
                </div>
            </div>
            <div class="form-group">
                <label for="subject" class="col-sm-2 control-label">Subject</label>
                <div class="col-sm-10">
                    <input class="form-control" name="subject">
                </div>
            </div>
            <div class="form-group">
                <label for="message" class="col-sm-2 control-label">Message</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="message" rows="3"></textarea>
                </div>
            </div>
        </form>
    </div>
@endsection
