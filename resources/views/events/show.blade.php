@extends('layouts.app')

@section('title', 'Event Details')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Event Details</h4>
        </div>
        <div class="pb-20 px-3">
            <div class="form-group">
                <label for="event_name">Event Name:</label>
                <p>{{ $event->event_name }}</p>
            </div>
            <div class="form-group">
                <label for="event_date">Event Date:</label>
                <p>{{ $event->event_date->format('d M Y, H:i') }}</p>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <p>{{ $event->location }}</p>
            </div>
            <div class="form-group">
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Back to Events</a>
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">Edit Event</a>
            </div>
        </div>
    </div>
@endsection
