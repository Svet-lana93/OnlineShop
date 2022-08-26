<x-layout>
    <div class="container">
        <x-slot name="title">User update</x-slot>
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
        <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="firstname" class="form-label"><b>Firstname:</b></label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ $user->firstname }}">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label"><b>Lastname:</b></label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $user->lastname }}">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label"><b>Username:</b></label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><b>Email:</b></label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label"><b>Mobile:</b></label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $user->mobile }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</x-layout>
