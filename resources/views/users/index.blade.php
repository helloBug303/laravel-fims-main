@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="mb-3" style="text-align: left; margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400;">
        <h2>Admin Management</h2>
    </div>

<!-- Search and Filter Form -->
<div class="row mb-4">
    <!-- Search Section -->
    <div class="col-md-6">
        <form action="{{ route('users.index') }}" method="GET" class="form-inline d-flex">
            <div class="form-group flex-grow-1 mr-2">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}" style="padding: 5px 10px; width: 100%;">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="glyphicon glyphicon-search"></i> 
            </button>
            <!-- Clear Button -->
            <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2" style="padding: 5px 10px;">
                Clear
            </a>
        </form>
    </div>

    <!-- Filter Section (Aligned to the right) -->
    <div class="col-md-6 ml-auto text-right" style="padding-bottom: 20px;">
        <form action="{{ route('users.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <select name="status" class="form-control" style="width: 150px;">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">
                Filter
            </button>
        </form>
    </div>
</div>

    <div class="panel panel-default" style="width: 120%; max-width: 1500px; margin: 0 auto;">
        <div class="panel-heading" style="padding: 20px;">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Admin List</span>
            </strong>
            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm pull-right">
                <i class="glyphicon glyphicon-plus"></i> Add New Admin
            </a>
        </div>

        <div class="panel-body" style="padding: 30px;">
            @if(session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th class="text-center">Status</th>
                            <th>Last Login</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td class="text-center">
                                    @if($user->status === 1)
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-danger">Deactive</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($user->last_login)->format('F d, Y, h:i:s a') }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $user->id }}" title="Remove">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="confirmDeleteLabel{{ $user->id }}">Confirm Deletion</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            Are you sure you want to delete this user? This action cannot be undone.
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush

@endsection
