@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-3 p-5">
        <img src="https://miro.medium.com/max/1400/1*Oycl8CLogYXYC_c1PWX7Tg.jpeg" class="rounded-circle" height="120px" width="120">
      </div>
      <div class="col-9 pt-5">
            <div><h1>{{ $user->username }}</h1></div>
            <div class="d-flex">
                <div class="pr-5"><strong>158</strong> posts</div>
                <div class="pr-5"><strong>23k</strong> followers</div>
                <div class="pr-5"><strong>996</strong> following</div>
            </div>
            <div class="pt-3 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
      </div>
  </div>
  <div class="row pt-5">
      <div class="col-4">
          <img src="https://rforcats.net/assets/img/programmer.png" class="w-100" height="300">
 </div>
 <div class="col-4">
          <img src="https://www.meme-arsenal.com/memes/ba744116d7443ca998b5955e5b0ea458.jpg" class="w-100" height="300">
</div>
<div class="col-4">
          <img src="https://image.shutterstock.com/image-photo/beige-cat-headphones-using-silver-260nw-1764311762.jpg" class="w-100" height="300">
</div>
      </div>
  </div>
</div>
@endsection