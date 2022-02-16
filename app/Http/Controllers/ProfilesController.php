<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;


class ProfilesController extends Controller
{
    public function index(User $user){

        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        // Cache saving for posts, followers and following
        $postCount = Cache::remember(
            'count.posts.' . $user->id, 
            now()->addSeconds(30), 
            function () use ($user) {
            return $user->posts->count();
        });

        $followersCount = Cache::remember(
            'count.followers.' . $user->id, 
            now()->addSeconds(30), 
            function () use ($user) {
            return $user->profile->followers->count();
        });

        $followingCount = Cache::remember(
            'count.following.' . $user->id, 
            now()->addSeconds(30), 
            function () use ($user) {
            return $user->following->count();
        });

        return view('profiles/index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit($user){

        $user = User::findOrFail($user);

        $this->authorize('update', $user->profile);

        return view('profiles/edit', ['user' => $user]);

    }

    public function update(User $user){

        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => '',
            'image' => '',
        ]);

        if (request('image')){
            $imagePath = request('image')->store('profile', 'public');
            //php artisan storage:link

             // composer require intervention/image
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $data = array_merge($data, ['image' => $imagePath]);
        }


        auth()->user()->profile->update($data);

        return redirect("/profile/{$user->id}");

    }

    // php artisan make:policy ProfilePolicy -m Profile

}