@extends('layouts.app')

@section('content')

<div class="container mt-4">
<div style="text-align: left; margin-bottom: 50px;  margin-top: 40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight: 400; ">
        <h2>Media</h2>
    </div>
    <div class="panel panel-default" style="max-width: 1500px; margin: 0 auto; overflow-y: auto;">
        <div class="panel-heading clearfix" style="padding: 20px;">
            <strong>
                <span class="glyphicon glyphicon-camera"></span>
                <span>All Photos</span>
            </strong>

            <div class="pull-right">
                <form class="form-inline" action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="file_upload" multiple class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-upload"></span> Upload
                    </button>
                </form>
            </div>
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
                            <th class="text-center" style="width: 20%;">Photo</th>
                            <th class="text-center" style="width: 30%;">Photo Name</th>
                            <th class="text-center" style="width: 30%;">Photo Type</th>
                            <th class="text-center" style="width: 70px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($media_files as $media_file)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                            <img src="{{ asset('lib/products/' . $media_file->file_name) }}" style="height: 80px; width: auto;">
                            </td>
                            <td class="text-center">{{ $media_file->file_name }}</td>
                            <td class="text-center">{{ $media_file->file_type }}</td>
                            <td class="text-center">
                                <form action="{{ route('media.destroy', $media_file->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" title="Delete">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No media files available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
