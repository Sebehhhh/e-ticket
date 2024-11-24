@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Create New User</h4>
        </div>
        <div class="pb-20 px-3"> <!-- Menambahkan kelas px-3 di sini -->
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label> <!-- Menambahkan label untuk password -->
                    <input type="password" class="form-control" id="password" name="password" required>
                    <!-- Menambahkan input untuk password -->
                </div>
                <div class="form-group">
                    <label for="isAdmin">Is Admin</label>
                    <select class="form-control" id="isAdmin" name="isAdmin">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
