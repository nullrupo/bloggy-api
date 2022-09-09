@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Inventory</h2>
            </div>
            <div class="pull-right">
                @can('blog-create')
                <a class="btn btn-success" href="{{ route('blog.create') }}"> Create New Entry</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th width="30px">No</th>
            <th width="60px">Name</th>
            <th width="50px">Detail</th>
            <th width="140px">Action</th>
        </tr>
	    @foreach ($blog as $blog)
	    <tr>
	        <td>{{ $blog->id }}</td>
	        <td>{{ $blog->name }}</td>
            <td>{{ $blog->detail }}</td>
	        <td>
                <form action="{{ route('blog.destroy',$blog->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('blog.show',$blog->id) }}">Show</a>
                    @can('blog-edit')
                    <a class="btn btn-primary" href="{{ route('blog.edit',$blog->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('blog-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

@endsection
