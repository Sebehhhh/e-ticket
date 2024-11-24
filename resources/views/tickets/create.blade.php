@extends('layouts.app')

@section('title', 'Create Ticket')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Create New Ticket</h4>
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

            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="event_id">Event</label>
                    <select class="form-control" id="event_id" name="event_id" required>
                        <option value="">Select Event</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->event_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="ticket_quantity">Ticket Quantity</label>
                    <input type="number" class="form-control" id="ticket_quantity" name="ticket_quantity" required
                        min="1">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" required step="0.01"
                        min="0">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Ticket</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
