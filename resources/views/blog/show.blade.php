@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Inventory</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('blog.index') }}"> Back</a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ID:</strong>
                {{ $blog->id }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $blog->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Detail:</strong>
                {{ $blog->detail }}
            </div>
        </div>
    </div>
    <h4>Display Comments</h4>
  
    @include('blog.comments', ['comments' => $blog->comments, 'blog_id' => $blog->id])
   
   <hr />
   <form method="post" action="{{ route('comments.store') }}">
       @csrf
       <div class="form-group">
           <textarea class="form-control" name="body"></textarea>
           <input type="hidden" name="blog_id" value="{{ $blog->id }}" />
       </div>
       <div class="form-group">
           <input type="submit" class="btn btn-success" value="Add Comment" />
       </div>
   </form>

  <hr />
@endsection
