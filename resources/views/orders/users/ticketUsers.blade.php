@extends('layouts.app')

@section('title')
    Ticket Catalog
@endsection

@section('content')
    <div class="container">
        <h4 class="text-blue h4 mb-4">Ticket Catalog</h4>

        <div class="row">
            @foreach ($tickets as $ticket)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-img-top text-center"
                            style="height: 200px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 48px; color: #333;">
                            {{ strtoupper(substr($ticket->event->event_name, 0, 2)) }}
                            <!-- Mengambil dua huruf pertama dari nama event -->
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $ticket->event->event_name }}</h5>
                            <p class="card-text">Quantity Available: {{ $ticket->ticket_quantity }}</p>
                            <p class="card-text">Price: Rp{{ number_format($ticket->price, 2) }}</p>
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <div class="form-group">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" name="quantity" class="form-control" min="1"
                                        max="{{ $ticket->quantity }}" value="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Order Ticket</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
