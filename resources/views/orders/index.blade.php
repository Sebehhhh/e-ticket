@extends('layouts.app')

@section('title')
    Orders
@endsection

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Order Data Table</h4>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Create Order</a>
            <!-- Tombol untuk menambahkan order -->
        </div>
        <div class="pb-20 px-3">
            <table class="data-table table stripe hover nowrap">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort">Order ID</th>
                        <th>Event</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th class="datatable-nosort">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="table-plus">{{ $loop->iteration }}</td>
                            <td>{{ $order->ticket->event->event_name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>Rp{{ number_format($order->total_price, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d H:i') }}</td>
                            <td>
                                @if ($order->status === 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($order->status === 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($order->status === 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-secondary">Unknown</span>
                                @endif
                            </td>

                            @if ($order->status === 'pending')
                                <!-- Tampilkan tombol hanya jika statusnya pending -->
                                <td>
                                    <!-- Tombol Accept -->
                                    <form action="{{ route('orders.accept', $order->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Are you sure you want to accept this order?');">Accept</button>
                                    </form>

                                    <!-- Tombol Reject -->
                                    <form action="{{ route('orders.reject', $order->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to reject this order?');">Reject</button>
                                    </form>
                                </td>
                            @else
                                <td>
                                    @if ($order->status === 'completed')
                                        <span class="text-success">Order has been accepted.</span>
                                    @elseif($order->status === 'rejected')
                                        <span class="text-danger">Order has been rejected.</span>
                                    @endif
                                </td>
                            @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                        href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                        <a class="dropdown-item" href="{{ route('orders.show', $order) }}"><i
                                                class="dw dw-eye"></i>
                                            View</a>
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
