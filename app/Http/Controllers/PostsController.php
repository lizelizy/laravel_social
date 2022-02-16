<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

// Intervention image package
use Intervention\Image\Facades\Image;

class PostsController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        //users that auth user is following
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts/index', compact('posts'));
    }

    public function create(){
        return  view('posts/create');
    }

    public function store(){

        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
            
            
        ]);

        $imagePath = request('image')->store('uploads', 'public');
        //php artisan storage:link

        // composer require intervention/image
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/profile/' . auth()->user()->id);
    }

    //route model binding
    public function show(\App\Models\Post $post){

        return view('posts/show',[
            'post' => $post,
        ]);

    }
}
