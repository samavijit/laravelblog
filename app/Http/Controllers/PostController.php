<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Comment;

use App\Category;
use App\Photo;

use Auth;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $posts = Post::latest()->paginate(1);
       
        return view('posts.index', compact('posts'))
                        ->with('i', (request()->input('page', 1) - 1) * 1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category =  Category::pluck('name','id')->toArray();


        return view('posts.create',compact('category'));
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
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        if($request->photo_id == '')
        {
            $input = $request->except('photo_id');
        }
        else
        {
            $input = $request->all();
        }

        if($request->hasfile('photo_id')) 
        { 
            $file = $request->file('photo_id');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('images', $filename);
            $photo = Photo::create(['file'=>$filename]);
            $input['photo_id'] = $photo->id;
        }

        $user = Auth::User();

        $user->post()->create($input);

        return redirect()->route('posts.index')
                        ->with('success','Post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $category =  Category::pluck('name','id')->toArray();

        return view('posts.edit',compact('post','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        if($request->photo_id == '')
        {
            $input = $request->except('photo_id');
        }
        else
        {
            $input = $request->all();
        }

        if($request->hasfile('photo_id')) 
        { 
            $file = $request->file('photo_id');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('images', $filename);
            $photo = Photo::create(['file'=>$filename]);
            $input['photo_id'] = $photo->id;
        }

        $user = Auth::User()->post()->whereId($id)->first()->update($input);

        
        return redirect()->route('posts.index')
                        ->with('success','Post edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post =  Post::findOrFail($id);

       if($post->photo)
       {

        unlink(public_path().$post->photo->file);
       }

       $post->delete();
        
        return redirect()->route('posts.index')
                        ->with('success','Article deleted successfully');
    }

    public function post($slug)
    {
       
        $post = Post::where('slug', '=' ,$slug)->firstOrFail();
        $comments = $post->comments()->whereIsActive(1)->get();
        return view('post',compact('post','comments'));
    }
}
