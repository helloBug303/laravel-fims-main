@extends('layouts.app')

@section('content')
<div class="container">
    <div class="center-wrapper">
        <!-- Session Messages -->
        @if(session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Form Panel -->
        <div class="panel panel-default">
            <div class="panel-heading bg-primary text-white">
                <strong>Update {{ $user->name }} Account</strong>
            </div>
            <div class="panel-body">
                <form method="POST" action="{{ route('user.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status">
                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Deactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-info">Update</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
