<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\ApI\BaseController as BaseController;
use Validator;
use App\Http\Resources\Blog as BlogResource;

class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blog-list|blog-create|blog-edit|blog-delete', ['only' => ['index','show']]);
        $this->middleware('permission:blog-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $blog = Blog::latest()->paginate(5);
        return view('blog.index',compact('blog'));
        return $this->sendResponse(BlogResource::collection($blog), 'Blogs retrieved successfully.');
    }
 


    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request, $validator)
    {
        $validator = request()->validate([
            'name'         => 'required',
            'detail'       => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        Blog::create($request->all());

        return redirect()->route('blog.index')
                         ->with('success','Entry created successfully.');
        return $this->sendResponse(new BlogResource($blog), 'Blog created successfully.');
    } 

    public function show(Blog $blog)
    {
        return view('blog.show',compact('blog'));
        return $this->sendResponse(new BlogResource($blog), 'Blog retrieved successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('blog.edit',compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validator = request()->validate([
            'name'         => 'required',
            'detail'       => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $blog->update($request->all());

        return redirect()->route('blog.index')
                         ->with('success','Entry updated successfully');
        return $this->sendResponse(new BlogResource($blog), 'blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blog.index')
                         ->with('success','Entry deleted successfully');
        return $this->sendResponse([], 'blog deleted successfully.');                 
    }
}
