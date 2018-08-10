<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

use Auth;
use App\Post;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::latest()->paginate(5);
        return view('comments.index',compact('comments'))
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
        $this->validate($request, [
        
            'body' => 'required'
           
        ]);

       $user = Auth::User();

        $data = [
            'post_id'=>$request->post_id,
            'author'=>$user->name,
            'email'=>$user->email,
            'body'=>$request->body,
        ];

        Comment::Create($data);
      
        return redirect()->back()
                        ->with('success','Your comment submitted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $posts = Post::findOrFail($id);

        $comments = $posts->comments;

       // dd($comment);


        return view('comments.show',compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $update =  Comment::findOrFail($id)->update($request->all());

        
        return redirect()->route('comments.index')
                        ->with('success','successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment =  Comment::findOrFail($id);

        $comment->delete();
        
        return redirect()->route('comments.index')
                        ->with('success','successfully');
    }
}
