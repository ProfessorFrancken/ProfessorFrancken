@component('mail::message')
    {{-- Body --}}
# Hi {{ $full_name }},

You have been given an account which you can use to login to our website.

### Reset your password

To login please first set password by clicking the button below.
Use your email, **{{ $email }}**.

@component('mail::button', ['url' => $url])
    Set your password
@endcomponent

### What to do with your account

- See your [latest expenses]({{ action([\Francken\Association\Members\Http\ExpensesController::class, 'index']) }})
- See [all photos]({{ action([\Francken\Association\Photos\PhotosController::class, 'index']) }})
- More features will be added in the future

@endcomponent
