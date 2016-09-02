<html lang="en">
    @include('layout.head')

    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
        @include('layout.navigation')

        <!-- Header -->
        <!-- background-image: url('http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/11/das_header-1080x400.png') -->
        <header style="background-color: #31255E; margin-top: -120px;">
            <div style="width:100%; height: 400px; color: white;">
                <h1 style="padding-top: 200px; text-align: center;  font-size: 50px">T.F.V. 'Professor Francken'</h1>
                <hr class="small">
            </div>
        </header>

        <!-- <img style="width: 100%" src="http://www.professorfrancken.nl/wordpress/wp-content/uploads/2013/11/das_header-1080x400.png"> -->

        <div class="container-fluid">
            @yield('content')
        </div>

        <div class="about-francken container-fluid">
            <div class="row">
                <div class="association col-sm-3 col-sm-offset-1">
                    <h3>Association</h3>
                    <p>
                        Vel fringilla est ullamcorper eget nulla facilisi etiam dignissim diam quis enim lobortis scelerisque fermentum dui faucibus in ornare quam viverra orci sagittis eu volutpat! Id diam maecenas ultricies mi?
                    </p>
                </div>
                <div class="study col-sm-3">
                    <h3>Study</h3>
                    <p>
                        Nulla facilisi cras fermentum, odio eu feugiat pretium, nibh ipsum consequat nisl, vel pretium lectus quam id leo in vitae turpis massa sed elementum tempus. Massa placerat duis ultricies lacus.
                    </p>

                </div>
                <div class="carreer col-sm-3">
                    <h3>Carreer</h3>
                    <p>
                        Aliquam, purus sit amet luctus venenatis, lectus magna fringilla urna, porttitor rhoncus dolor purus non enim praesent elementum facilisis leo, vel fringilla est? Ornare massa, eget egestas purus viverra accumsan.
                    </p>
                </div>
            </div>
        </div>

        @include('layout.footer')
        @include('layout.javascript')
    </body>
</html>
