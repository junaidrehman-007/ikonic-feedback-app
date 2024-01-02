<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
      
        $validatedData = $request->validate([
            'feedback_id' => 'required|exists:feedback,id', 
            'content' => 'required|string',
        ]);
    
      
        $comment = new Comment();
        $comment->feedback_id = $validatedData['feedback_id'];
        $comment->user_id = auth()->user()->id; 
        $comment->content = $validatedData['content'];
        $comment->save();
    

        return back()->with('success', 'Comment posted successfully');
    }
    
}
