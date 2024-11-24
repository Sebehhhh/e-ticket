@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">User Details</h4>
        </div>
        <div class="pb-20 px-3">
            <div class="form-group">
                <label for="name">Name:</label>
                <p>{{ $user->name }}</p>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <p>{{ $user->username }}</p>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <p>{{ $user->email }}</p>
            </div>
            <div class="form-group">
                <label for="isAdmin">Is Admin:</label>
                <p>{{ $user->isAdmin ? 'Yes' : 'No' }}</p>
            </div>
            <div class="form-group">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users List</a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit User</a>
            </div>
        </div>
    </div>
@endsection
