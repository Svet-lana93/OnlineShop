<x-layout>
        <div class="container">
            <x-slot name="title">Update</x-slot>
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
                <form action="{{ route('admins.update', ['id' => $admin->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Firstname</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="{{ $admin->firstname }}" @if($admin != auth()->user()) disabled @endif>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Lastname</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $admin->lastname }}" @if($admin != auth()->user()) disabled @endif>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ $admin->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" @if($admin == auth()->user()) disabled @endif>
                            <option value="new" {{ $admin->status == 'new' ? 'selected' : '' }}>New</option>
                            <option value="active" {{ $admin->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="disabled" {{ $admin->status == 'disabled' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
</x-layout>
