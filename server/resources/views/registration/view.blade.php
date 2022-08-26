<x-registration-auth-layout>
    <x-slot name="title">Registration</x-slot>
    <div class="row justify-content-center align-items-center">
        <div>
            @if ($errors->any())
                <div>
                    <ul class="color-red">
                        @foreach($errors->all() as $error)
                            <li> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <form action="{{ route('registration.register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="firstname" class="form-label">Firstname:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Lastname:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
            </div>
            <div class="mb-3">
                <label for="passwordRepeat" class="form-label">Please repeat your password:</label>
                <input type="password" class="form-control" id="passwordRepeat" name="passwordRepeat" value="{{ old('password') }}">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</x-registration-auth-layout>
