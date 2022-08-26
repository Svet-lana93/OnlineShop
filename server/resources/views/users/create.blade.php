<x-layout>
    <div class="container">
        <x-slot name="title">User create</x-slot>
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
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="firstname" class="form-label"><b>Firstname:</b></label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label"><b>Lastname:</b></label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label"><b>Username:</b></label>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><b>Email:</b></label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label"><b>Mobile:</b></label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</x-layout>
