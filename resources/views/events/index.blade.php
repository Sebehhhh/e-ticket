@extends('layouts.app')

@section('title', 'Events')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Events List</h4>
            <a href="{{ route('events.create') }}" class="btn btn-primary">Create Event</a>
        </div>
        <div class="pb-20 px-3">
            <table class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort">#</th>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Location</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td class="table-plus">{{ $loop->iteration }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->event_date }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="{{ route('events.show', $event) }}">
                                            <i class="dw dw-eye"></i> View
                                        </a>
                                        <a class="dropdown-item" href="{{ route('events.edit', $event) }}">
                                            <i class="dw dw-edit2"></i> Edit
                                        </a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Are you sure you want to delete this event?')">
                                                <i class="dw dw-delete-3"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
