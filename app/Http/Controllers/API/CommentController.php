<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Comment;
use Validator;
use App\Http\Resources\Comment as CommentResource;
 
class CommentController extends BaseController
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $comments = Comment::all();
 
        return $this->sendResponse(CommentResource::collection($comments), 'Comments retrieved successfully.');
    }
 
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $input = $request->all();
 
        $validator = Validator::make($input, [
            'name' => 'required',
            'comment' => 'required'
        ]);
 
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
 
        $comment = Comment::create($input);
 
        return $this->sendResponse(new CommentResource($comment), 'Comment created successfully.');
    } 
 
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
 
    public function show($id)
    {
        $comment = Comment::find($id);
        if (is_null($comment)) {
            return $this->sendError('Comment not found.');
        }
 
        return $this->sendResponse(new CommentResource($comment), 'Comment retrieved successfully.');
    }
 
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
 
    public function update(Request $request, Comment $comment)
    {
        $input = $request->all();
 
        $validator = Validator::make($input, [
            'name' => 'required',
            'comment' => 'required'
        ]);
 
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
 
        $comment->name = $input['name'];
        $comment->comment = $input['comment'];
        $comment->save();
 
        return $this->sendResponse(new CommentResource($comment), 'Comment updated successfully.');
    }
 
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return $this->sendResponse([], 'Comment deleted successfully.');
    }
}
