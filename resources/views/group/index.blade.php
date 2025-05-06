@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>Manage Groups</strong>
                <a href="{{ route('group.create') }}" class="btn btn-info pull-right btn-sm">Add New Group</a>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Group Name</th>
                            <th class="text-center" style="width: 20%;">Group Level</th>
                            <th class="text-center" style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ ucwords($group->group_name) }}</td>
                                <td class="text-center">{{ ucwords($group->group_level) }}</td>
                                <td class="text-center">
                                    @if($group->group_status === '1')
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('group.edit', $group->id) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <form action="{{ route('group.destroy', $group->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
