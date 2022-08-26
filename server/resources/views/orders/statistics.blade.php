<x-layout>
    <form action="{{ route('orders.statistics') }}" method="GET">
        <div class="input-group mb-3 product-row">
            <span class="input-group-text"><b>Date from:</b></span>
            <input type="date" aria-label="Date from" name="dateFrom" class="form-control" value="{{ $dateFrom ?? null }}">
            <span class="input-group-text"><b>Date to:</b></span>
            <input type="date" aria-label="Date to" name="dateTo" class="form-control" value="{{ $dateTo ?? null }}">
            <button type="submit" class="btn btn-primary">Check</button>
        </div>
    </form>

    <div class="container">
        <x-slot name="title">Order statistics</x-slot>
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Amount of orders:</b></span>
            <span class="input-group-text" id="amount"><b>{{ $amountOfOrders}}</b></span>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text"><b>Total price:</b></span>
            <span class="input-group-text" id="totalPrice"><b>{{ $totalPrice}}</b></span>
        </div>
    </div>
</x-layout>
