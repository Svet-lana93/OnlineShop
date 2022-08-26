<x-layout>
    <div class="container">
        <x-slot name="title">Admins</x-slot>
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
                <div class="col-md-2">
                    <label for="filterByStatus" class="form-label"></label>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="filterByStatus" name="status">
                        <option value="">Status</option>
                        <option value="new" {{ (!empty($filters['status']) && $filters['status'] === 'new') ? "selected" : ''}}>New</option>
                        <option value="active" {{ (!empty($filters['status']) && $filters['status'] === 'active') ? "selected" : ''}}>Active</option>
                        <option value="disabled" {{ (!empty($filters['status']) && $filters['status'] === 'disabled') ? "selected" : ''}}>Disabled</option>
                    </select>
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
                    <th>Email</th>
                    <th>Status</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->firstname }}</td>
                        <td>{{ $admin->lastname }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->status }}</td>
                        <td>
                            <a href="{{ route('admins.admin', ['id' => $admin->id]) }}">View</a>
                        </td>
                        <td>
                            <a href="{{ route('admins.delete', ['id' => $admin->id]) }}"  @if(auth()->user() == $admin) class="disabled" @endif>Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
