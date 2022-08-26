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

    });
</script>

<x-layout>
    <div class="container">
        <x-slot name="title">Create order</x-slot>
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

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                @foreach($products as $product)
                    <div class="input-group mb-3 product-row">
                        <div class="input-group-text">
                            <label for="product_id" class="form-label"></label>
                            <input class="form-check-input mt-0 product-checkbox" type="checkbox" name="product[]" value="{{ $product->id}}">
                        </div>
                        <span class="input-group-text"><b>Product title:</b></span>
                        <span class="input-group-text col-md-4 title">{{ $product->title }}</span>
                        <span class="input-group-text"><b>Product price:</b></span>
                        <span class="input-group-text col-md-2 price" data-price="{{ $product->price }}">{{ $product->price }}</span>
                        <span class="input-group-text"><b>Product quantity:</b></span>
                        <input type="number" aria-label="Product quantity" name="product_quantity[]" class="form-control quantity" value="">
                    </div>
                @endforeach
                <label class="label"></label>

                <div class="input-group mb-3">
                    <span class="input-group-text"><b>Total price:</b></span>
                    <span class="input-group-text" id="totalPrice"><b></b></span>
                </div>
                <div class="mb-3">
                    <label for="deliveryAddress" class="form-label"><b>Delivery address:</b></label>
                    <input type="text" class="form-control" id="deliveryAddress" name="delivery_address" value="{{ old('delivery_address') }}">
                </div>
                <div class="mb-3">
                    <label for="user" class="form-label"><b>User:</b></label>
                    <select class="form-select" id="user" name="user_id">
                        <option value="">Choose a user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->getName($user) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</x-layout>
