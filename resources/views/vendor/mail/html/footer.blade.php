<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center" style="padding-bottom: 15px">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                    <p>
                    Nijenborgh 4, 9747 AG Groningen, Tel: 050 363 4978
                    </p>
                    <p>
                        <a href='https://professorfrancken.nl/' style="color: #999; text-decoration: none;">
                            https://professorfrancken.nl
                        </a>
                    </p>
                    <p>
                        <a href="https://www.linkedin.com/groups/1524067" class="m-x">
                            <img src="{{ url('/images/mail/linkedin.png') }}"/>
                        </a>
                        <a href="https://www.facebook.com/groups/139490187648/" class="m-x">
                            <img src="{{ url('/images/mail/facebook.png') }}"/>
                        </a>
                        <a href="https://www.instagram.com/tfvprofessorfrancken/" class="m-x">
                            <img src="{{ url('/images/mail/instagram.png') }}"/>
                        </a>
                    </p>
                </td>
            </tr>
            <tr>
                <td class="footer-sponsor-cell">
                    <a href='https://www.asml.nl/careers'>
                        <img
                            src='{{ url('images/mail/asml_mail_banner.jpg') }}'
                            alt='Careers at ASML'
                            style='border:1px solid grey;'
                            class="footer-sponsor"
                        >
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>
