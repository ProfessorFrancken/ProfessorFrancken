<form action="{{ action([\Francken\Association\Photos\Http\Controllers\AuthenticationController::class, 'store']) }}"
      class="form d-flex flex-column justify-content-between"
      method="post"
>
    @csrf
    <input name="password" type="password" class="form-control my-2" id="password" placeholder="Password">
    <button type="submit" class="btn btn-primary">Login</button>
</form>
