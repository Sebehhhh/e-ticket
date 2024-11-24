@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Order Detail</h4>
        </div>
        <div class="pb-20 px-3">
            <h5>Order ID: {{ $order->id }}</h5>
            <p><strong>Event:</strong> {{ $order->ticket->event->event_name }}</p>
            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
            <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
            <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d H:i') }}</p>

            <h5>Ticket Codes</h5>
            <ul>
                @foreach ($ticketCodes as $ticketCode)
                    <li>{{ $ticketCode->code }}</li>
                @endforeach
            </ul>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
        </div>
    </div>
@endsection
