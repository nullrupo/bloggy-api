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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
 
        $validator = Validator::make($input, [
            'body'=>'required',
        ]);
 
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        };
        $input['user_id'] = auth()->user()->id;
        Comment::create($input);
        
        return back();
    }

    public function index()
    {
        $cmt = Comment::all();
 
        return $this->sendResponse(CommentResource::collection($cmt), 'Comment retrieved successfully.');
    }
}