@extends('homepage.layout')

{{--

<div class="header__logo">
                    <div class="row align-items-center">
                        <div class="col text-right">
                            <img alt="" src="/images/LOGO_KAAL.png" height="100px" class="float-right"/>
                        </div>
                        <div class="col">
                            <h1 class="header__title text-left">
                                T.F.V.<br/>
                                'Professor<br/>
                                Francken'
                            </h1>
                        </div>
                    </div>
                </div>
      --}}

@section('content')
    <header>
        <div class="row no-gutters">
            <div class="col-md-4 text-right">
                <div class="header__logo align-middle align-items-center">
                    <div class="d-flex justify-content-end align-items-center">

                    <img
                        alt=""
                        src="/images/LOGO_KAAL.png"
                        height="100px"
                    />
                    <h1 class="header__title text-left float-right">
                        T.F.V.<br/>
                        'Professor<br/>
                        Francken'
                    </h1>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="header__navigation">

                </div>
            </div>
        </div>
        <!-- <div class="header__logo-1"> -->
        <!-- <img alt="" src="/images/LOGO_KAAL.png"/> -->
        <!-- </div> -->
        <!-- <nav class="header__nav"><!--  -->

        <!-- </nav> -->

        <div class="overflowwing">
            <div class="header__registration-cta">
                <div class="registration-cta container h-100">
                    <div class="row align-items-center h-100">
                        <div class="registration-cta__body text-right col-md-4 offset-md-5 align-self-center">

                            <h1>
                                Become part of
                                <small>
                                    the best student association
                                </small>
                            </h1>

                            <p class="small">
                                Mauris rhoncus aenean vel.
                            </p>
                        </div>
                        <div class="col-md-1 text-left registration-cta__button">
                            <button class="btn btn-primary">Wordt lid</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    {{--

<div class="register-cta">
            <div class="container">
                <div class="row align-items-center">
                    <div class="text-right col-md-4 offset-md-7">

                        <h1>
                            Wordt lid van
                            <small>
                                de leukste vereniging
                            </small>
                        </h1>

                        <p class="small">
                            Egestas fringilla phasellus faucibus scelerisque eleifend donec.
                        </p>
                    </div>
                    <div class="col-md-1 text-left">
                        <button class="btn btn-primary">Wordt lid</button>
                    </div>
                </div>
            </div>

        </div>
      --}}



    <div class="container">

        <div class="row">
            <div class="col about-francken">
                <div class="row">
                    <div class="col-md-4">
                        <div class="about-francken__j-c-francken">
                            <img alt="" src="http://www.professorfrancken.nl/wordpress/media/images/ereleden/profjcfrancken.png" class="rounded-circle" style="width: 200px; height: 200px; overflow: hidden;"/>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="section-header">
                            About T.F.V. 'Professor Francken'
                        </h2>

                        <p>
                            Orci dapibus ultrices in iaculis nunc sed augue lacus, viverra vitae congue eu, consequat ac felis donec et odio pellentesque diam! Fringilla urna, porttitor rhoncus dolor purus non enim praesent!
                        </p>
                    </div>
                </div>
                <p>
                    Sit amet, aliquam id diam maecenas ultricies mi eget mauris pharetra et ultrices neque ornare aenean euismod elementum nisi, quis? Facilisis sed odio morbi quis commodo odio aenean sed adipiscing.
                </p>

                <div class="text-right">
                    <button class="btn btn-primary">Read more</button>
                </div>
            </div>
            <div class="col-md-4 offset-md-1">
                @include("homepage.agenda")
            </div>

            <div class="row">
                <div class="col text-right">
                    <img alt="" src="https://unsplash.it/500/300"/>
                </div>
                <div class="col-md-5">
                    <h3 class="section-header">The latest Francken Vrij</h3>
                    <p>
                        Ultricies mi, quis hendrerit dolor magna eget est lorem ipsum dolor sit amet, consectetur adipiscing elit pellentesque habitant morbi tristique senectus et netus et? Malesuada fames ac turpis egestas maecenas.
                    </p>
                    <button class="btn btn-primary">Read me</button>
                    <a class="link" href="">View all Francken Vrijs</a>
                </div>
            </div>
        </div>
    </div>

    <div class="news">
        <div class="container">
            <h2 class="section-header text-center">Latest news</h2>
            <div class="row">
                <article class="col news-item">
                    <div class="news-item__date">
                        12 nov 2016
                    </div>
                    <div class="news-item__written-by">
                        Mark Boer
                    </div>
                    <p class="news-item__preview">
                        Elementum facilisis leo, vel fringilla est ullamcorper eget nulla facilisi etiam dignissim? Facilisis volutpat, est velit egestas dui, id ornare arcu odio ut sem nulla pharetra diam sit amet nisl.
                    </p>
                    <button class="btn btn-primary">Read more</button>
                </article>

                <article class="col news-item">
                    <div class="news-item__date">
                        12 nov 2016
                    </div>
                    <div class="news-item__written-by">
                        Mark Boer
                    </div>
                    <p class="news-item__preview">
                        Ut pharetra sit amet, aliquam id diam maecenas ultricies mi eget mauris pharetra et ultrices neque ornare aenean! Tempus quam pellentesque nec nam aliquam sem et tortor consequat id porta?
                    </p>
                    <button class="btn btn-primary">Read more</button>
                </article>

                <article class="col news-item">
                    <div class="news-item__date">
                        12 nov 2016
                    </div>
                    <div class="news-item__written-by">
                        Mark Boer
                    </div>
                    <p class="news-item__preview">
                        Sed vulputate odio ut enim blandit volutpat maecenas volutpat. Nisi lacus, sed viverra tellus in hac habitasse platea dictumst vestibulum rhoncus est pellentesque elit ullamcorper dignissim cras tincidunt lobortis feugiat.
                    </p>
                    <button class="btn btn-primary">Read more</button>
                </article>
            </div>
            <div class="row">
                <div class="col-md-4 offset-md-8">
                    <p class="text-center">
                        <a class="link" style="color: white" href="">View all news</a>
                    </p>
                </div>
            </div>


            <div class="card-deck">
                <div class="card card-outline-primary mb-3 text-center">
                    <div class="card-block">
                        <div class="news-item__date">
                            12 nov 2016
                        </div>
                        <div class="news-item__written-by">
                            Mark Boer
                        </div>
                        <p class="card-text">
                            Viverra vitae congue eu, consequat ac felis donec et odio pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus. Eget dolor morbi non arcu risus, quis varius quam quisque!
                        </p>
                    </div>

                    <div class="card-footer text-left">
                        <button class="btn btn-primary">Read more</button>
                    </div>
                </div>
                <div class="card card-outline-primary mb-3 text-center">
                    <div class="card-block">
                        <div class="news-item__date">
                            12 nov 2016
                        </div>
                        <div class="news-item__written-by">
                            Mark Boer
                        </div>
                        <p class="card-text">
                            Eleifend quam adipiscing vitae proin sagittis, nisl rhoncus mattis rhoncus, urna neque viverra justo, nec ultrices dui sapien. Non pulvinar neque laoreet suspendisse interdum consectetur libero, id faucibus nisl tincidunt.
                        </p>
                    </div>

                    <div class="card-footer text-left">
                        <button class="btn btn-primary">Read more</button>
                    </div>
                </div>
                <div class="card card-outline-primary mb-3 text-center">
                    <div class="card-block">
                        <div class="news-item__date">
                            12 nov 2016
                        </div>
                        <div class="news-item__written-by">
                            Mark Boer
                        </div>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                    </div>

                    <div class="card-footer text-left">
                        <button class="btn btn-primary">Read more</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="about rounded-circle">
                    <h3>Study</h3>
                    <p>
                        moi
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="about rounded-circle">
                    <h3>Association</h3>
                    <p>
                        doei
                    </p>
                </div>
            </div>

            <div class="col">
                <div class="about rounded-circle">
                    <h3>Carreer</h3>
                    <p>
                        ja hallo
                    </p>
                </div>
            </div>
        </div>


    </div>


    {{--
    <nav class="navbar fixed-bottom navbar-light bg-faded">

    <div class="container">


        <h1>Hello, world!</h1>

        <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
        <button type="button" class="btn btn-primary">Primary</button>

        <!-- Secondary, outline button -->
        <button type="button" class="btn btn-secondary">Secondary</button>

        <!-- Indicates a successful or positive action -->
        <button type="button" class="btn btn-success">Success</button>

        <!-- Contextual button for informational alert messages -->
        <button type="button" class="btn btn-info">Info</button>

        <!-- Indicates caution should be taken with this action -->
        <button type="button" class="btn btn-warning">Warning</button>

        <!-- Indicates a dangerous or potentially negative action -->
        <button type="button" class="btn btn-danger">Danger</button>

        <!-- Deemphasize a button by making it look like a link while maintaining button behavior -->
        <button type="button" class="btn btn-link">Link</button>

        <div class="btn">
            Moi
        </div>

    </div>
        <a class="navbar-brand" href="#">Fixed bottom</a>
    </nav>
    --}}

    <footer>

    </footer>
@endsection
