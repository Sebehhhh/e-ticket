@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Edit User</h4>
        </div>
        <div class="pb-20 px-3">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank if not changing">
                    <!-- Tambahkan placeholder untuk memberi tahu bahwa password opsional -->
                </div>
                <div class="form-group">
                    <label for="isAdmin">Is Admin</label>
                    <select class="form-control" id="isAdmin" name="isAdmin">
                        <option value="0" {{ $user->isAdmin == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $user->isAdmin == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
