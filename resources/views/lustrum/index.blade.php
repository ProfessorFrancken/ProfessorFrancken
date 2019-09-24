@extends('layout.one-column-layout')

@section('main-content')
    <div class="container my-5">
        <h2 class="section-header section-header--centered">
            7th Lustrum
        </h2>

        <p class="lead text-center px-5 my-5">
            On the 42nd week of 2019 T.F.V. 'Professor Francken' celebrates her 35th birthday.
            Join one of the pirate crews and help your crew win the lustrum competition by completing challenges troughout the week.
        </p>

        <h3 class="text-center">Passepartout</h3>

        <p class="lead text-center px-5 mb-5">
            Don't want to miss out of all the fun? Buy a <strong>Passepartout</strong> for &euro;28,- to get free access to all events and a very personal wristband.
        </p>

        <ul class="list-unstyled justify-content-between shadow d-none">
            <li class="bg-info text-white px-5 py-4 rounded-left border border-dark text-center" style="width: 43%">
                <h2 class="text-center text-white mb-4">Blue Beards</h2>

                <img src="{{ url('uploads/images/lustrum/bluebeard.png') }}" alt="" class="img-fluid"/>

                <button class="btn btn-block btn-light">
                    Join
                </button>
            </li>
            <li class="bg-danger text-white px-5 py-4 rounded-right border border-dark text-center" style="width: 57%">
                <h2 class="text-center text-white mb-4">Red Beards</h2>

                <img src="{{ url('uploads/images/lustrum/redbeard.png') }}" alt="" class="img-fluid"/>

                <button class="btn btn-block btn-light">
                    Join
                </button>
            </li>
        </ul>

        <!-- background-image: url('https://i.ytimg.com/vi/qImPaM4lKoA/maxresdefault.jpg');
        -->
        <ul class="list-unstyled">
            <li style="
                       padding: 4em;
                       position: relative;
                       overflow: hidden;
                       "
                class="my-5 rounded shadow-sm"
            >
                <div style="
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            background-color: #273151;
                            background: linear-gradient(to top left, #4d5bc4, #a41786);
                            z-index: -2;
                            ">
                </div>
                <div
                    style="
                           top: 0;
                           left: 0;
                           right: 0;
                           bottom: 0;
                           position: absolute;
                           mix-blend-mode: multiply;
                           filter: grayscale(100%);
                           width: 100%;
                           height: 100%;
                           object-fit: cover;
                           background-size: cover;
                           background-blend-mode: multiply;
                           background-image: url('https://i.ytimg.com/vi/qImPaM4lKoA/maxresdefault.jpg');
                           z-index: -1;
                           "
                >
                </div>
                <div style="" class="">
                    <div class="d-flex justify-content-between text-white" style="font-size: 1.25rem; margin-bottom: 4em;">
                        <span class="font-weight-bold">
                            Monday October 7th<br/>
                            17:00
                        </span>
                        <span class="font-weight-bold">
                            Franckenroom
                        </span>
                    </div>
                    <h2 class="text-white text-center h1 py-5 my-5 mt-4">
                        <div class="d-flex justify-content-center align-items-end mb-2">
                            <span style="color: #7171f7; font-size: 4rem; width: 4em; line-height: 1em;" class="mx-3 text-right">
                                Shark
                            </span>
                            <span style="color: white; font-size: 3rem; justify-self:center" class="mx-3">
                                vs
                            </span>
                            <span style="color: #dd3e22; font-size: 4rem; width: 4em; line-height: 1em;" class="mx-3 text-left">
                                Crocodile
                            </span>
                        </div>
                        <div class="text-center">
                            Borrel
                        </div>
                    </h2>

                    <ul class="text-white font-weight-bold" style="font-size: 1.5rem; list-style: disc;">
                        <li><span style="color: #ff9200; font-size: 1.75rem;">Free</span> beer for <span style="color: #ff9200; font-size: 2.0rem;">&euro;5,-</span></li>
                        <li>Fishing with Eva Visser</li>
                        <li>Adventcalendar</li>
                    </ul>
                </div>
            </li>

            <li style="
                       padding: 4em;
                       position: relative;
                       overflow: hidden;
                       "
                class="my-5 rounded shadow-sm"
            >
                <div style="
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            background-color: #273151;
                            background: linear-gradient(to top left, #4d5bc4, #a41786);
                            z-index: -2;
                            ">
                </div>
                <div
                    style="
                           top: 0;
                           left: 0;
                           right: 0;
                           bottom: 0;
                           position: absolute;
                           mix-blend-mode: multiply;
                           filter: grayscale(100%);
                           width: 100%;
                           height: 100%;
                           object-fit: cover;
                           background-size: cover;
                           background-blend-mode: multiply;
                           background-image: url('https://ksr-ugc.imgix.net/assets/014/496/598/dc6af42bb5c8f3f74ba4efae94e8925f_original.jpg?ixlib=rb-2.1.0&crop=faces&w=1552&h=873&fit=crop&v=1479055883&auto=format&frame=1&q=92&s=0cce530c382b7cbdaee2d14a7990da78');
                           z-index: -1;
                           "
                >
                </div>
                <div style="" class="">
                    <div class="d-flex justify-content-between text-white" style="font-size: 1.25rem; margin-bottom: 4em;">
                        <span class="font-weight-bold">
                            Tuesday October 8th<br/>
                            17:00
                        </span>
                        <span class="font-weight-bold">
                            Franckenroom
                        </span>
                    </div>
                    <h2 class="text-white text-center h1 py-5 my-5 mt-4">
                        <span class="text-center" style="color: #ff9200; font-size: 4rem;">
                            Build A Trebuchet
                        </span>
                        <div class=" justify-content-center align-items-end mb-2 d-none" style="color: #ff9200;">
                            <span style="font-size: 4rem; width: 4em; line-height: 1em;" class="mx-3 text-right">
                                Build
                            </span>
                            <span style="font-size: 3rem; justify-self:center" class="mx-1">
                                a
                            </span>
                            <span style="font-size: 4rem; width: 4em; line-height: 1em;" class="mx-3 text-left">
                                Trebuchet
                            </span>
                        </div>
                        <div class="text-center">
                            Borrel
                        </div>
                    </h2>

                    <ul class="text-white font-weight-bold list-unstyled" style="font-size: 1.5rem;">
                        <li>
                            Build a lifesize trebuchet for <span style="color: #ff9200; font-size: 2.0rem;">&euro;8,-</span>
                        </li>
                    </ul>
                </div>
            </li>

            <li style="
                       padding: 4em;
                       position: relative;
                       overflow: hidden;
                       "
                class="my-5 rounded shadow-sm"
            >
                <div style="
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            background-color: #273151;
                            background: linear-gradient(to top left, #4d5bc4, #a41786);
                            z-index: -2;
                            ">
                </div>
                <div
                    style="
                           top: 0;
                           left: 0;
                           right: 0;
                           bottom: 0;
                           position: absolute;
                           mix-blend-mode: multiply;
                           filter: grayscale(100%);
                           width: 100%;
                           height: 100%;
                           object-fit: cover;
                           background-size: cover;
                           background-blend-mode: multiply;
                           background-image: url('https://www.julieslifestyle.com/src/Frontend/Files/blog/images/968x560/mushroom-avocado-sushi-rolls-vegan-gluten-free-inspiration-anett-velsberg-en-662.jpg');
                           z-index: -1;
                           "
                >
                </div>
                <div style="" class="">
                    <div class="d-flex justify-content-between text-white" style="font-size: 1.25rem; margin-bottom: 4em;">
                        <span class="font-weight-bold">
                            Wednesday October 9th<br/>
                            17:00
                        </span>
                        <span class="font-weight-bold">
                            TBA
                        </span>
                    </div>
                    <h2 class="text-white text-center h1 py-5 my-5 mt-4">
                        <span class="text-center" style="color: #ff9200; font-size: 4rem;">
                            Creative thursday
                        </span>
                    </h2>

                    <ul class="text-white font-weight-bold list-unstyled" style="font-size: 1.5rem;">
                        <li>
                            Sushi workshop for <span style="color: #ff9200; font-size: 2.0rem;">&euro;?,-</span>
                        </li>
                        <li>
                            <span style="color: #ff9200; font-size: 2.0rem;">*</span> Not included in the passepartout
                        </li>
                    </ul>
                </div>
            </li>


            <li style="
                       padding: 4em;
                       position: relative;
                       overflow: hidden;
                       "
                class="my-5 rounded shadow-sm"
            >
                <div style="
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            background-color: #273151;
                            background: linear-gradient(to top left, #4d5bc4, #a41786);
                            z-index: -2;
                            ">
                </div>
                <div
                    style="
                           top: 0;
                           left: 0;
                           right: 0;
                           bottom: 0;
                           position: absolute;
                           mix-blend-mode: multiply;
                           filter: grayscale(100%);
                           width: 100%;
                           height: 100%;
                           object-fit: cover;
                           background-size: cover;
                           background-blend-mode: multiply;
                           background-image: url('https://pensacolaliquor.com/files/Treasure%20Map%20no%20x.JPG');
                           z-index: -1;
                           "
                >
                </div>
                <div style="" class="">
                    <div class="d-flex justify-content-between text-white" style="font-size: 1.25rem; margin-bottom: 4em;">
                        <span class="font-weight-bold">
                            Thursday October 10th<br/>
                            17:00
                        </span>
                        <span class="font-weight-bold">
                            Mystery
                        </span>
                    </div>
                    <h2 class="text-white text-center h1 py-5 my-5 mt-4">
                        <span class="text-center" style="color: #ff9200; font-size: 4rem;">
                            Mysteryhunt Wetnessday
                        </span>
                    </h2>

                    <ul class="text-white font-weight-bold list-unstyled" style="font-size: 1.5rem;">
                        <li>
                            Find the hidden treassure chest
                        </li>
                        <li>
                            Costs: <span style="color: #ff9200; font-size: 2.0rem;">&euro;5,-</span>
                        </li>
                    </ul>
                </div>
            </li>

            <li style="
                       padding: 4em;
                       position: relative;
                       overflow: hidden;
                       "
                class="my-5 rounded shadow-sm"
            >
                <div style="
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            background-color: #273151;
                            background: linear-gradient(to top left, #4d5bc4, #a41786);
                            z-index: -2;
                            ">
                </div>
                <div
                    style="
                           top: 0;
                           left: 0;
                           right: 0;
                           bottom: 0;
                           position: absolute;
                           mix-blend-mode: multiply;
                           filter: grayscale(100%);
                           width: 100%;
                           height: 100%;
                           object-fit: cover;
                           background-size: cover;
                           background-blend-mode: multiply;
                           background-image: url('https://www.margaretriver.com/wp-content/uploads/2018/12/SILENT-DISCO-boat-party-london-optimised.jpg');
                           z-index: -1;
                           "
                >
                </div>
                <div style="" class="">
                    <div class="d-flex justify-content-between text-white" style="font-size: 1.25rem; margin-bottom: 4em;">
                        <span class="font-weight-bold">
                            Friday October 11th<br/>
                            17:00
                        </span>
                        <span class="font-weight-bold">
                            Franckenroom
                        </span>
                    </div>
                    <h2 class="text-white text-center h1 py-5 my-5 mt-4">
                        <span class="text-center" style="color: #ff9200; font-size: 4rem;">
                            Silent Disco
                        </span>
                        <div class="text-center">
                            Borrel
                        </div>
                    </h2>

                    <ul class="text-white font-weight-bold" style="font-size: 1.5rem; list-style: disc">
                        <li>
                            With sushi and other ocean related food
                        </li>
                        <li>
                            Costs: <span style="color: #ff9200; font-size: 2.0rem;">&euro;5,-</span>
                        </li>
                    </ul>
                </div>
            </li>

            <li style="
                       padding: 4em;
                       position: relative;
                       overflow: hidden;
                       "
                class="my-5 rounded shadow-sm"
            >
                <div style="
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            background-color: #273151;
                            background: linear-gradient(to top left, #4d5bc4, #a41786);
                            z-index: -2;
                            ">
                </div>
                <div
                    style="
                           top: 0;
                           left: 0;
                           right: 0;
                           bottom: 0;
                           position: absolute;
                           mix-blend-mode: multiply;
                           filter: grayscale(100%);
                           width: 100%;
                           height: 100%;
                           object-fit: cover;
                           background-size: cover;
                           background-blend-mode: multiply;
                           background-image: url('https://cdn.pixabay.com/photo/2017/05/21/19/45/groningen-2332073_960_720.jpg');
                           z-index: -1;
                           "
                >
                </div>
                <div style="" class="">
                    <div class="d-flex justify-content-between text-white" style="font-size: 1.25rem; margin-bottom: 4em;">
                        <span class="font-weight-bold">
                            Saturday October 12th<br/>
                            15:00
                        </span>
                        <span class="font-weight-bold">
                            Groningen
                        </span>
                    </div>
                    <h2 class="text-white text-center h1 py-5 my-5 mt-4">
                        <span class="text-center" style="color: #ff9200; font-size: 4rem;">
                            Alumni day
                        </span>
                    </h2>

                    <ul class="text-white font-weight-bold" style="font-size: 1.5rem; list-style: disc">
                        <li>
                            15:00 - 17:30 : Canal trip
                        </li>
                        <li>
                            18:00 - 21:00 : Dinner at Francken
                        </li>
                        <li>
                            18:00 - 21:00 : Beer at Francken
                        </li>
                        <li>
                            22:00 - ??:?? : End party with Fom at Dizkartes
                        </li>
                    </ul>
                </div>
            </li>
            <li style="
                       padding: 4em;
                       position: relative;
                       overflow: hidden;
                       "
                class="my-5 rounded shadow-sm"
            >
                <div style="
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            background-color: #273151;
                            background: linear-gradient(to top left, #4d5bc4, #a41786);
                            z-index: -2;
                            ">
                </div>
                <div
                    style="
                           top: 0;
                           left: 0;
                           right: 0;
                           bottom: 0;
                           position: absolute;
                           mix-blend-mode: multiply;
                           filter: grayscale(100%);
                           width: 100%;
                           height: 100%;
                           object-fit: cover;
                           background-size: cover;
                           background-blend-mode: multiply;
                           background-image: url('https://www.4mijl.nl/media/3486/4mijl-2017-0046.jpg?anchor=center&mode=crop&width=550&height=400&rnd=131684514000000000');
                           z-index: -1;
                           "
                >
                </div>
                <div style="" class="">
                    <div class="d-flex justify-content-between text-white" style="font-size: 1.25rem; margin-bottom: 4em;">
                        <span class="font-weight-bold">
                            Sunday October 13th<br/>
                            13:00 - 16:00
                        </span>
                        <span class="font-weight-bold">
                            Groningen
                        </span>
                    </div>
                    <h2 class="text-white text-center h1 py-5 my-5 mt-4">
                        <span class="text-center" style="color: #ff9200; font-size: 4rem;">
                            4 Mile
                        </span>
                    </h2>

                    <ul class="text-white font-weight-bold list-unstyled" style="font-size: 1.5rem; list-style: none">
                        <li>
                            Cheer on people running the 4 mile
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
@endsection
