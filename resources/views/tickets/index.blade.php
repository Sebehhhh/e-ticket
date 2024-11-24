@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Tickets List</h4>
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">Create Ticket</a>
        </div>
        <div class="pb-20 px-3">
            <table class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort">#</th>
                        <th>Event</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="table-plus">{{ $loop->iteration }}</td>
                            <td>{{ $ticket->event->event_name }}</td>
                            <td>{{ $ticket->ticket_quantity }}</td>
                            <td>Rp{{ number_format($ticket->price, 2) }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="{{ route('tickets.show', $ticket) }}">
                                            <i class="dw dw-eye"></i> View
                                        </a>
                                        <a class="dropdown-item" href="{{ route('tickets.edit', $ticket) }}">
                                            <i class="dw dw-edit2"></i> Edit
                                        </a>
                                        <form action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item"
                                                onclick="return confirm('Are you sure you want to delete this ticket?')">
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
