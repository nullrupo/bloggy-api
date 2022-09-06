@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Inventory</h2>
            </div>
            <div class="pull-right">
                @can('product-create')
                <a class="btn btn-success" href="{{ route('product.create') }}"> Create New Entry</a>
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
	    @foreach ($product as $product)
	    <tr>
	        <td>{{ $product->id }}</td>
	        <td>{{ $product->name }}</td>
            <td>{{ $product->detail }}</td>
	        <td>
                <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('product.show',$product->id) }}">Show</a>
                    @can('product-edit')
                    <a class="btn btn-primary" href="{{ route('product.edit',$product->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('product-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

@endsection
