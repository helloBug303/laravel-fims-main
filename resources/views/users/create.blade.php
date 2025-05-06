@extends('layouts.app')

@section('content')

<div class="container form-wrapper">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Add New User</span>
            </strong>
        </div>

        <div class="panel-body">
            @if(session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif

            <!-- Show validation errors -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.store') }}">
                @csrf

                <div class="form-group">
                    <label for="full_name">Name</label>
                    <input type="text" class="form-control" name="full_name" placeholder="Full Name" required value="{{ old('full_name') }}">
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Username" required value="{{ old('username') }}">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

 

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
