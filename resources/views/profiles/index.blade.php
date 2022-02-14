@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-3 p-5">
        <img src="https://miro.medium.com/max/1400/1*Oycl8CLogYXYC_c1PWX7Tg.jpeg" class="rounded-circle" height="120px" width="120">
      </div>
      <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
              <h1>{{ $user->username }}</h1>
            <a href="/p/create">Add new post</a>
            </div>
            <div class="d-flex">
                <div class="pr-5"><strong>{{ $user->posts->count() }}</strong> posts</div>
                <div class="pr-5"><strong>23k</strong> followers</div>
                <div class="pr-5"><strong>996</strong> following</div>
            </div>
            <div class="pt-3 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
      </div>
  </div>
  <div class="row pt-5">
    @foreach($user->posts as $post)
    <div class="col-4 pb-4">
          <a href="/p/{{$post->id}}">
          <img src="/storage/{{ $post->image }}" class="w-100" height="300">
          </a>
</div>
    @endforeach  


      </div>
  </div>
</div>
@endsection