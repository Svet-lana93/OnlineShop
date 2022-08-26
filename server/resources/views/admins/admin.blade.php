<x-layout :admin="$admin">
    <div class="container">
        <x-slot name="title">Admin</x-slot>

        <table class="table table-striped">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Firstname: </b>{{ $admin->firstname }}</li>
                <li class="list-group-item"><b>Lastname: </b>{{ $admin->lastname }}</li>
                <li class="list-group-item"><b>Email: </b>{{ $admin->email }}</li>
                <li class="list-group-item"><b>Status: </b>{{ $admin->status }}</li>
            </ul>
        </table>

        <div>
            <a href="{{ route('admins.edit', ['id' => $admin->id]) }}">Update</a>
        </div>
    </div>
</x-layout>
