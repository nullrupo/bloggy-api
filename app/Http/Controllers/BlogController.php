<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Validator;

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
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required',
            'detail'       => 'required',
        ]);
        Blog::create($request->all());

        return redirect()->route('blog.index')
                         ->with('success','Entry created successfully.');
    } 

    public function show(Blog $blog)
    {
        return view('blog.show',compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('blog.edit',compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $this->validate($request, [
            'name'         => 'required',
            'detail'       => 'required',
        ]);
        $blog->update($request->all());

        return redirect()->route('blog.index')
                         ->with('success','Entry updated successfully');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blog.index')
                         ->with('success','Entry deleted successfully');          
    }
}
