<x-layout>
    <div class="container">
        <x-slot name="title">Products</x-slot>
        <form action="" method="GET">
            @csrf
            <div class="row g-3 gx-5 align-items-center">
                <div class="col-md-2">
                    <label for="title" class="form-label">Filter by:</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Name" value="{{ $filters['title'] ?? '' }}">
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
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <a href="{{ route('products.edit', ['id' => $product->id]) }}">Update</a>
                        </td>
                        <td>
                            <a href="{{ route('products.delete', ['id' => $product->id]) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <a href="{{ route('products.create') }}">Add new product</a>
        </div>
    </div>
</x-layout>
