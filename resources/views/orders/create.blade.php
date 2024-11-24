@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Create New Order</h4>
        </div>
        <div class="pb-20 px-3">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Menambahkan kelas px-3 di sini -->
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="ticket_id">Select Ticket</label>
                    <select class="form-control" id="ticket_id" name="ticket_id" required>
                        <option value="">Select Ticket</option>
                        @foreach ($tickets as $ticket)
                            <option value="{{ $ticket->id }}">
                                {{ $ticket->event->event_name }} - ${{ number_format($ticket->price, 2) }} (Available:
                                {{ $ticket->ticket_quantity }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required min="1"
                        max="10">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Order</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
