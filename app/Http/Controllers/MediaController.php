<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Photo;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::latest()->paginate(5);
       
        return view('medias.index', compact('photos'))
                        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('medias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('images', $filename);
            $photo = Photo::create(['file'=>$filename]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo =  Photo::findOrFail($id);

       if($photo)
       {
            if(file_exists(public_path().$photo->file))
            {
                unlink(public_path().$photo->file);
            }

       }

       $photo->delete();
        
        return redirect()->route('medias.index')
                        ->with('success','Article deleted successfully');
    }

    public function deleteMedia(Request $request)
    {

        //return ($request->checkboxArray);

        $photos = Photo::findOrFail($request->checkboxArray);

        foreach ($photos as $key => $photo) {
            
            if($photo)
            {
                if(file_exists(public_path().$photo->file))
                {
                    unlink(public_path().$photo->file);
                }
            }

            $photo->delete();
        }
        return redirect()->route('medias.index')
                        ->with('success','Media deleted successfully');
    }
}
