<x-layout>
    <div class="container">
        <x-slot name="title">Orders</x-slot>
        <form action="" method="GET">
            @csrf
            <div class="row g-3 gx-5 align-items-center">
                <div class="col-md-2">
                    <label for="name" class="form-label">Filter by:</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                           value="{{ $filters['name'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <label for="productTitle" class="form-label">
                        <input type="text" class="form-control" id="productTitle" name="productTitle"
                               placeholder="Product title" value="{{ $filters['productTitle'] ?? '' }}">
                    </label>
                </div>
                <div class="col-md-2">
                    <label for="filterByStatus" class="form-label"></label>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="filterByStatus" name="status">
                        <option value="">Status</option>
                        <option
                            value="new" {{ (!empty($filters['status']) && $filters['status'] === 'new') ? "selected" : ''}}>
                            New
                        </option>
                        <option
                            value="paid" {{ (!empty($filters['status']) && $filters['status'] === 'paid') ? "selected" : ''}}>
                            Paid
                        </option>
                        <option
                            value="sent" {{ (!empty($filters['status']) && $filters['status'] === 'sent') ? "selected" : ''}}>
                            Sent
                        </option>
                        <option
                            value="completed" {{ (!empty($filters['status']) && $filters['status'] === 'completed') ? "selected" : ''}}>
                            Completed
                        </option>
                        <option
                            value="closed" {{ (!empty($filters['status']) && $filters['status'] === 'closed') ? "selected" : ''}}>
                            Closed
                        </option>
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
                <th>Order id</th>
                <th>User</th>
                <th>Product title</th>
                <th>Product quantity</th>
                <th>Total price</th>
                <th>Delivery address</th>
                <th>Status</th>
                <th>Date</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->firstname }} {{ $order->user->lastname }}</td>
                    <td>
                        @foreach($order->products as $product)
                           <div>{{ $product->title }}</div>
                        @endforeach
                    </td>
                    <td>
                        @foreach($order->orderProduct as $product)
                            <div>{{ $product->product_quantity }}</div>
                        @endforeach
                    </td>
                    <td>{{ $order->totalPrice() }}</td>
                    <td>{{ $order->delivery_address }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ date("Y-m-d H:i:s", strtotime($order->created_at))}}</td>
                    <td>
                        <a href="{{ route('orders.edit', ['id' => $order['id']]) }}">Update</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            <a href="{{ route('orders.create') }}">Create new order</a>
        </div>
    </div>
</x-layout>
