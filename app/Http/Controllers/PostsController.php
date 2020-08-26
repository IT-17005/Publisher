<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show','home']]);
    }

    public function index()
    {
        //
        //return Post::all();
       // $posts = Post::all();
       // $posts = Post::orderBy('title','desc')->get();
       // $posts = Post::orderBy('title','asc')->get();
   $posts = DB::select('select *from posts');
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:2048'
            ]);
             if($request->hasFile('cover_image')){
                 //GET FILE NAME WITH EXTENTION
             $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
             //GET JUST FILE NAME
             $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
             // GET JUST EXT
             $extension = $request->file('cover_image')->getClientOriginalExtension();
             //file name to store
             $fileNameToStore = $fileName.'_'.time().'.'.$extension;
             // upload image
             $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
             }
             else{
                 $fileNameToStore = 'noimage.jpg';
             }


        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
        $post->save();
        return redirect('/posts')->with('success','post created.');
       //return view('posts.index');
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
        //return Post::find($id);
        $post = Post::find($id);

        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if((auth()->user()->id !== $post->user_id)){
            return redirect('/posts')->with('error','Unauthorized Access.');
        }
        return view('posts.edit')->with('post',$post);
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

        $this -> validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:2048'
            ]);

             if($request->hasFile('cover_image')){
                 //GET FILE NAME WITH EXTENTION
             $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
             //GET JUST FILE NAME
             $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
             // GET JUST EXT
             $extension = $request->file('cover_image')->getClientOriginalExtension();
             //file name to store
             $fileNameToStore = $fileName.'_'.time().'.'.$extension;
             // upload image
             $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
             }

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();
        return redirect('/posts')->with('success','post Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if((auth()->user()->id !== $post->user_id)){
            return redirect('/posts')->with('error','Unauthorized Access.');
        }

        if($post->cover_image != 'noimage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post -> delete();
        return redirect('/posts')->with('success','Post removed');
    }
}
