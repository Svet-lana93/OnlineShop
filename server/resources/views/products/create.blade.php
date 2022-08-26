<x-layout>
        <div class="container">
            <x-slot name="title">Create a product</x-slot>
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
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label"><b>Title:</b></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title')}}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label"><b>Description:</b></label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label"><b>Price:</b></label>
                        <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
</x-layout>
