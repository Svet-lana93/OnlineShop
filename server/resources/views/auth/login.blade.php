<x-registration-auth-layout>
    <x-slot name="title">Authorisation</x-slot>
    <div class="row justify-content-center align-items-center mb-3">
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
        <form action="" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <a href="{{ route('registration.register-page') }}">Create an account</a>
</x-registration-auth-layout>

