@component('mail::message')
    {{-- Body --}}
# Hi {{ $full_name }},

You have been given an account which you can use to login to the website of our association [T.F.V. 'Professor Francken'](https://professorfrancken.nl).
You can use this account to view your [latest expenses]({{ action([\Francken\Association\Members\Http\ExpensesController::class, 'index']}}) at our association and [view photos]({{ action([\Francken\Association\Photos\Http\Controllers\PhotosController::class, 'index']) }}) of activities.
In the future we will add more features such as changing your personal information, registering online for activities managing your committees and more.

### Reset your password

To login please first set a password by clicking the button below.
Use your email, **{{ $email }}**.

@component('mail::button', ['url' => $url])
    Set your password
@endcomponent

@endcomponent
