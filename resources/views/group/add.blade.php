@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New User</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <!-- Show success or error messages -->
          @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
          @endif

          @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
          @endif

          <!-- Form to add user -->
          <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}" required>
                @error('full_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>
                @error('username')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
            </div>

            <div class="form-group">
              <label for="level">User Role</label>
                <select class="form-control" name="level" required>
                  @foreach ($groups as $group)
                    <option value="{{ $group->group_level }}">{{ ucwords($group->group_name) }}</option>
                  @endforeach
                </select>
            </div>

            <div class="form-group clearfix">
              <button type="submit" class="btn btn-primary">Add User</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


