@component('mail::message')

Dear {{ $name }},

Around **{{ $date }}** there will be a bank incasso by T.F.V. 'Professor Francken'.

For you this includes the following:

**{{ $description}}**.

The total of **&euro;{{ $deduction_amount }}** will be taken from your IBAN around {{ $date }}.
Please make sure you have enough money on your bank account in time.


Kind regards,


Rosa de Graff<br/>
*Treasurer of  T.F.V. &#8216;Professor Francken&#8217;*
@endcomponent
