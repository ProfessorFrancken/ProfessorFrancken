<tr>
    <td class="header">
        <table class="inner-header" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="header-logo-cell" style="text-align: right; padding-right: 20px;">
                    <img src="{{ $src ?? url('/images/mail/small_white_logo.png') }}" class="header-logo"/>
                </td>
                <td class="">
                    <a href="{{ $url }}" class="header-title">
                        {{ $slot }}
                    </a>
                </td>
            </tr>
        </table>
    </td>
</tr>
