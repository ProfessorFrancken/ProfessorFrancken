<h5 class="mb-3 mt-4">Other details</h5>
<div class="row">
    <div class="col col-md-4">
        <h6>
            <i class="fas fa-fw fa-mail-bulk"></i>
            Mailing lists
        </h6>

        <ul class="list-unstyled">
            
            <li>
                @if($member->mailinglist_email)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Mailinglist email</strong>
            </li>
            <li>
                @if($member->mailinglist_post)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Mailinglist post</strong>
            </li>
            <li>
                @if($member->mailinglist_sms)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Mailinglist sms</strong>
            </li>
            <li>
                @if($member->mailinglist_constitutiekaart)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Mailinglist constitutional card</strong>
            </li>
            <li>
                @if($member->mailinglist_franckenvrij)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Mailinglist Francken Vrij</strong>
            </li>
        </ul>
        
    </div>
    <div class="col col-md-4">
        <h6>
            <i class="fas fa-fw fa-money-check-alt"></i>
            Finances and membership
        </h6>

        <ul class="list-unstyled">
            <li>
                @if($member->machtiging)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Debit authorization</strong>
            </li>
            <li>
                @if($member->wanbetaler)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Defaulter (Dutch: Wanbetaler)</strong>
            </li>
            <li>
                @if($member->is_lid)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Is member</strong>:
                {{ $member->start_lidmaatschap }}
                @if($member->einde_lidmaatschap)
                    - {{ $member->einde_lidmaatschap }}
                @endif
            </li>
            <li>
                @if($member->erelid)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Member of honors</strong>
            </li>
            <li>
                @if($member->gratis_lidmaatschap)
                    <i class="far fa-fw fa-check-square"></i>
                @else
                    <i class="far fa-fw fa-square"></i>
                @endif
                <strong>Free membership</strong>
            </li>
            <li>
                <strong>Iban</strong> {{  $member->payment_details->iban() }}
            </li>
            <li>
                <strong>Bank</strong> {{  $member->plaats_bank }}
            </li>
        </ul>
    </div>
    <div class="col col-md-4">
        <h6>
            Miscellaneous
        </h6>
        <ul class="list-unstyled">
            @if($member->werkgever)
                <li>
                    <strong>Employer</strong> {{  $member->werkgever }}
                </li>
            @endif
            @if($member->nnvnummer)
                <li>
                    <strong>NNV Number</strong> {{  $member->nnvnummer }}
                </li>
            @endif
        </ul>
    </div>
</div>
