@extends('layouts.app')
@section('content')
<div class="container">
  @include('components.alert')
  <div class="card">
    <div class="card-header" style="text-align: center">
        {{ $user_name }}  さんが紹介した動画数:{{  count($posts) }}
    </div>
  </div>
  <div class="row row-cols-1 row-cols-md-3">  
    @foreach ($posts as $post)
      <div class="col mb-4">
        <div class="card h-100">
          <a href="{{ route('posts.show',$post) }}">
            <img class="card-img-top" src="{{ $post->thumburl }}" alt="">
          </a>
          <div class="card-body">
            <a href="{{ route('posts.show',$post) }}" style="color:black">{{ $post->title }}</a>
            <a href="{{ route('channel.show',$post->channel_id) }}" style="color:black">
              <p class="card-text">{{ $post->channelTitle }}</p>
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="mx-auto" style="width: 200px;">
    {{-- {{ $posts->links() }} --}}
  </div>
</div>
@endsection
