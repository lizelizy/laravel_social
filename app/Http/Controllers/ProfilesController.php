<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Intervention\Image\Facades\Image;


class ProfilesController extends Controller
{
    public function index($user)
    {
        $user = User::findOrFail($user);

        return view('profiles/index', ['user' => $user]);
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