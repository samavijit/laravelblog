<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;
use App\Photo;

use DB;

class ArticleController extends Controller
{
    public function index()
    {
    	//return Article::all();

         $articles = Article::latest()->paginate(5);
        return view('articles.index',compact('articles'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }
    

    public function store(Request $request)
    {
         $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
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

        Article::create($input);
        
        return redirect()->route('articles.index')
                        ->with('success','Article created successfully');
    }


    public function show($id)
    {
        /*$data = Article::find($id);

        if(!empty($data))
        {
        	return response()->json([
        		'status'=>1,
                'Messege' => 'success',
                'result' => $data
            ],200);
        }
        else
        {
        	return response()->json([
        		'status'=>0,
                'Messege' => 'No record found',
                'result' => array()
            ],200);
        }*/

        $article = Article::findOrFail($id);
        return view('articles.show',compact('article'));
        
    }

     public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit',compact('article'));
    }


    
    public function update(Request $request, $id)
    {
        /*$article = Article::findOrFail($id);
        $article->update($request->all());
        return $article;*/

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
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
 
        Article::find($id)->update($input);

        return redirect()->route('articles.index')
                        ->with('success','Article updated successfully');
    }

     public function destroy($id)
    {
       $article =  Article::findOrFail($id);

       if($article->photo)
       {

        unlink(public_path().$article->photo->file);
       }

       $article->delete();
        
        return redirect()->route('articles.index')
                        ->with('success','Article deleted successfully');
    }

    public function delete(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        //print_r($article);exit;
        if($article->delete())
        {
            return response()->json([
                'status'=>1,
                'Messege' => 'success'
            ],200);
        }
        else
        {
            return response()->json([
                'status'=>0,
                'Messege' => 'Fail'
            ],200);
        }
    }

}
