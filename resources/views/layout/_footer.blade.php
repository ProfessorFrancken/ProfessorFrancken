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
        <div class="footer__contact-background footer__contact row flex-md-nowrap">
            <div class="col-12 col-sm-3 col-md-2 my-3">
                <h4 class="footer__header h5 mb-2">Address</h4>

                <address class="footer__body mb-0">
                    <i class="fa fa-map-marker-alt text-primary" aria-hidden="true"></i>
                    Nijenborgh 4<br>
                    <i class="fa fa-map-marker-alt invisible" aria-hidden="true"></i>
                    9747AG, Groningen<br>
                    <i class="fa fa-globe-africa invisible" aria-hidden="true"></i>
                    The Netherlands
                </address>
            </div>

            <div class="col-12 col-sm-5 col-md-4 col-lg-3 my-3">
                <h4 class="footer__header h5 mb-2">Contact</h4>

                <div class="footer__body">
                    <i class="far fa-envelope text-primary" aria-hidden="true"></i> <a href="malto: board@professorfrancken.nl">board@professorfrancken.nl</a> <br>
                    <i class="fa fa-phone text-primary" aria-hidden="true"></i> <a href="tel:+31503634978">tel: +31 (0) 50 363 4978</a> <br>

                    <a href="/contact"><u>More contact info</u></a>
                </div>
            </div>

            <div class="col-12 col-sm-4 col-md-4 my-3">
                <h4 class="footer__header h5 mb-2">Other</h4>

                <div class="footer__body" style="column-count: 2">
                    {{-- <a href="https://www.facebook.com/groups/139490187648/">
                        <i class="fab fa-facebook text-primary" aria-hidden="true"></i> Facebook<br>
                    </a> --}}

                    <a href="https://www.instagram.com/tfvprofessorfrancken/">
                        <i class="fab fa-instagram text-primary" aria-hidden="true"></i> Instagram<br>
                    </a>

                    <a href="https://www.linkedin.com/company/t.f.v.-professor-francken/?viewAsMember=true">
                        <i class="fab fa-linkedin text-primary" aria-hidden="true"></i> LinkedIn<br>
                    </a>
                    <a href="https://github.com/ProfessorFrancken/ProfessorFrancken">
                        <i class="fab fa-github-square text-primary" aria-hidden="true"></i> Github<br>
                    </a>
                    <a href="/privacy-policy">
                        <i class="fa fa-user-secret text-primary" aria-hidden="true"></i>
                        Privacy policy<br>
                    </a>
                    <a href="/public/pdf/Code_of_Conduct.pdf">
                        <i class="fas fa-gavel text-primary" aria-hidden="true"></i>
                        Code of conduct<br>
                    </a>
                    <a href="/cookies-policy">
                        <i class="fa fa-cookie-bite text-primary" aria-hidden="true"></i>
                        Cookies<br>
                    </a>

                    @impersonating($guard = null)
                    <a href="{{ route('impersonate.leave') }}">
                        <i class="fas fa-user-secret text-primary" aria-hidden="true"></i>
                        Leave impersonation
                    </a>
                    @endImpersonating
                </div>
            </div>

            {{-- Note: we add a padding left 0 since the gutter from the row adds a padding --}}
            <div class="col-12 col-md-2 col-lg-3 d-none d-lg-block footer__logo skew-md--bottom-right align-self-end"
                 style="
        box-shadow: 0 0px 5px rgba(0,0,0,0.2);
                        "

            >
                <div class="align-middle align-items-center">
                    <div class="d-flex justify-content-center justify-content-md-start align-items-center">
                        <a class="header__title-link" href="/">
                            @svg('LOGO_KAAL', 'svg-logo scaleUp--hover')
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <x-footer-sponsors/>
</footer>
