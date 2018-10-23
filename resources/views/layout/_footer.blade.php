<footer class="mt-md-5">
    @if (isset($editPageUrl))
        <div class="container">
            <p class="text-center my-5">
                <a href="{{ $editPageUrl }}">
                    Edit this page on github
                </a>
            </p>
        </div>
    @endif

    <div class="container-fluid">
        <div class="footer__contact-background footer__contact row">
            <div class="col-12 col-sm-3 col-md-2 my-3 order-2">
                <h4 class="footer__header h5 mb-3">Adress</h4>

                <address class="footer__body">
                    <i class="fa fa-map-marker-alt text-primary" aria-hidden="true"></i>
                    Nijenborgh 4<br>
                    <i class="fa fa-map-marker-alt invisible" aria-hidden="true"></i>
                    9747AG, Groningen<br>
                    <i class="fa fa-globe-africa invisible" aria-hidden="true"></i>
                    The Netherlands
                </address>
            </div>

            <div class="col-12 col-sm-5 col-md-4 col-lg-3 my-3 order-3">
                <h4 class="footer__header h5 mb-3">Contact</h4>

                <div class="footer__body">
                    <i class="far fa-envelope text-primary" aria-hidden="true"></i> <a href="malto: board@professorfrancken.nl">board@professorfrancken.nl</a> <br>
                    <i class="fa fa-phone text-primary" aria-hidden="true"></i> <a href="tel:+31503634978">tel: +31 (0) 50 363 4978</a> <br>

                    <a href="/contact"><u>More contact info</u></a>
                </div>
            </div>

            <div class="col-12 col-sm-4 col-md-2 my-3 order-4">
                <h4 class="footer__header h5 mb-3">Social Media</h4>

                <div class="footer__body">
                    <a href="https://www.facebook.com/groups/139490187648/">
                        <i class="fab fa-facebook text-primary" aria-hidden="true"></i> Facebook<br>
                    </a>
                    <a href="https://www.linkedin.com/groups/1524067">
                        <i class="fab fa-linkedin text-primary" aria-hidden="true"></i> LinkedIn<br>
                    </a>
                    <a href="https://github.com/ProfessorFrancken/ProfessorFrancken">
                        <i class="fab fa-github-square text-primary" aria-hidden="true"></i> Github
                    </a>
                </div>
            </div>

            <div class="col-12 col-sm-4 col-md-2 my-3 order-4">
                <h4 class="footer__header h5 mb-3">Policies</h4>

                <div class="footer__body">
                    <a href="/privacy-policy">
                        <i class="fa fa-user-secret text-primary" aria-hidden="true"></i>
                        Privacy policy<br>
                    </a>
                    <a href="/cookies-policy">
                        <i class="fa fa-cookie-bite text-primary" aria-hidden="true"></i>
                        Cookies<br>
                    </a>
                </div>
            </div>


            {{-- Note: we add a padding left 0 since the gutter from the row adds a padding --}}
            <div class="order-md-1 col-12 col-md-2 d-none d-md-block footer__logo skew-md--bottom-right">
                <div class="align-middle align-items-center">
                    <div class="d-flex justify-content-center justify-content-md-end align-items-center">
                        <a class="header__title-link" href="/">
                            <img alt="Logo of T.F.V. 'Professor Francken'" src="/images/LOGO_KAAL.png" class="img-fluid  scaleUp--hover" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>


    @include('layout._sponsors')
</footer>
