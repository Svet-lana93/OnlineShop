<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function(){
        function countTotal() {

            let total = 0;

            for (let row of $('.product-row')) {
                let checkbox = $(row).find('.product-checkbox');

                if( !$(checkbox).is(':checked')) {
                    $(row).find('.quantity').attr('name', '');
                    continue;
                }
                $(row).find('.quantity').attr('name', 'product_quantity[]');
                let price = parseFloat($(row).find('.price').attr('data-price'));
                let quantity = parseInt($(row).find('.quantity').val());

                if (isNaN(quantity)) {
                    quantity = 0;
                }
                total += price * quantity;
            }

            $("#totalPrice>b").text(total);
        }
        $('.product-row .product-checkbox, .product-row .quantity').change(function(){
            countTotal();
        });
        countTotal()
    });
</script>

<x-layout>
    <div class="container">
        <x-slot name="title">Update order</x-slot>
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

            <form action="{{ route('orders.update', ['id' => $order->id]) }}" method="POST">
                @csrf
                @method('PUT')

            @if($order->isNew())
                    @foreach($products as $key => $product)
                        @php
                            $orderProducts = (array)$order->orderProduct;
                            $orderProducts = array_shift($orderProducts);

                            $orderProduct = array_filter($orderProducts, function(\App\Models\OrderProduct $orderProduct) use ($product) {
                                return $product->id === $orderProduct->product->id;
                            });

                            $orderProduct = array_shift($orderProduct);
                        @endphp

                        <div class="input-group mb-3 product-row">
                            <div class="input-group-text">
                                <label for="product_id" class="form-label"></label>
                                <input class="form-check-input mt-0 product-checkbox" type="checkbox" name="product[]" value="{{ $product->id }}"
                                {{ null !== $orderProduct ? "checked" : ''}}>
                            </div>
                            <span class="input-group-text"><b>Product title:</b></span>
                            <span class="input-group-text col-md-4 title">{{ $product->title }}</span>
                            <span class="input-group-text"><b>Product price:</b></span>
                            <span class="input-group-text col-md-2 price" data-price="{{ $product->price }}">{{ $product->price }}</span>
                            <span class="input-group-text"><b>Product quantity:</b></span>
                            <input type="number" aria-label="Product quantity" name="product_quantity[]" class="form-control quantity"
                                       value="{{ null !== $orderProduct ? $orderProduct->product_quantity : 0 }}">
                        </div>
                    @endforeach
                    <div class="input-group mb-3">
                        <span class="input-group-text"><b>Total price:</b></span>
                        <span class="input-group-text" id="totalPrice"><b></b></span>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="deliveryAddress" class="form-label"><b>Delivery address:</b></label>
                    <input type="text" class="form-control" id="deliveryAddress" name="delivery_address" value="{{ $order->delivery_address }}">
                </div>
                <div class="mb-3">
                    <label for="user" class="form-label"><b>User:</b></label>
                    <input type="text" class="form-control" id="user" name="user_id" value="{{ $order->user->getName($order->user) }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label"><b>Order status:</b></label>
                    <select class="form-select" id="status" name="status">
                        <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>New</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="sent" {{ $order->status == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="closed" {{ $order->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</x-layout>
