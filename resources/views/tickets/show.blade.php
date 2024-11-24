@extends('layouts.app')

@section('title', 'Ticket Details')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Ticket Details</h4>
        </div>
        <div class="pb-20 px-3">
            <div class="form-group">
                <label for="event_id">Event</label>
                <p>{{ $ticket->event->event_name }}</p> <!-- Menampilkan nama event -->
            </div>
            <div class="form-group">
                <label for="ticket_quantity">Ticket Quantity</label>
                <p>{{ $ticket->ticket_quantity }}</p> <!-- Menampilkan jumlah tiket -->
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <p>Rp{{ number_format($ticket->price, 2) }}</p> <!-- Menampilkan harga tiket -->
            </div>
            <div class="form-group">
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back to Tickets</a>
                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-primary">Edit Ticket</a>
            </div>
        </div>
    </div>
@endsection
