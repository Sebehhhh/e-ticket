@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Edit Event</h4>
        </div>
        <div class="pb-20 px-3">
            <form action="{{ route('events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="event_name">Event Name</label>
                    <input type="text" class="form-control" id="event_name" name="event_name"
                        value="{{ $event->event_name }}" required>
                </div>
                <div class="form-group">
                    <label for="event_date">Event Date</label>
                    <input type="datetime-local" class="form-control" id="event_date" name="event_date"
                        value="{{ $event->event_date->format('Y-m-d\TH:i') }}" required>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}"
                        required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Event</button>
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
