<x-layout>
    <div class="container">
        <x-slot name="title">Users</x-slot>
        <form action="" method="GET">
            @csrf
            <div class="row g-3 gx-5 align-items-center">
                <div class="col-md-2">
                    <label for="name" class="form-label">Filter by:</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $filters['name'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label for="email" class="form-label">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ $filters['email'] ?? '' }}">
                    </label>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                <hr>
            </div>
        </form>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->firstname }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>
                            <a href="{{ route('users.edit', ['id' => $user->id]) }}">Update</a>
                        </td>
                        <td>
                            <a href="{{ route('users.delete', ['id' => $user->id]) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <a href="{{ route('users.create') }}">Create new user</a>
        </div>
    </div>
</x-layout>
