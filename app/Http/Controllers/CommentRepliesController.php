<?php

namespace App\Http\Controllers;

use App\CommentReply;
use App\Comment;
use Illuminate\Http\Request;

use Auth;

class CommentRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $replies = CommentReply::latest()->paginate(5);

        return view('comments.replies.index',compact('replies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CommentReply  $commentReply
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       

        $comments = Comment::findOrFail($id);


        $replies = $comments->replies;

       // dd($replies);


        return view('comments.replies.show',compact('replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommentReply  $commentReply
     * @return \Illuminate\Http\Response
     */
    public function edit(CommentReply $commentReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommentReply  $commentReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $update =  CommentReply::findOrFail($id)->update($request->all());

        
        return redirect()->back()->with('success','successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommentReply  $commentReply
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment =  CommentReply::findOrFail($id);

        $comment->delete();
        
        return redirect()->back()
                        ->with('success','successfully');
    }

    public function createReply(Request $request)
    {
        $this->validate($request, [
        
            'body' => 'required'
           
        ]);

       $user = Auth::User();

        $data = [
            'comment_id'=>$request->comment_id,
            'author'=>$user->name,
            'email'=>$user->email,
            'body'=>$request->body
        ];

        CommentReply::Create($data);
      
        return redirect()->back()
                        ->with('success','Your reply submitted successfully');
    }
}
