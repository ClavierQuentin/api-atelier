<form method="POST" class="custom-form" action="{{ route('email.delete') }}">
    @csrf
    <div class="form-group">
        <label for="email">Indiquez votre email</label>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <button>Se désinscrire</button>
</form>
