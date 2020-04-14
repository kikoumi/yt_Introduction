@extends('layouts.app')
@section('content')
<div class="container">
  @include('components.alert')
  <div class="text-center">
    <div class="mx-auto">
      <a href="{{ route('channel.show',$posts[0]->channel_id) }}">
        <img class="card-img-top rounded-circle" style="width: 150px; hight: 150px;" src="{{ $posts[0]->channel_thumburl }}" alt="">
      </a>
    </div>
    <h3 class="my-3 font-weight-bold  text-center">
      <a href="{{ route('channel.show',$posts[0]->channel_id) }}" class="text-dark">{{ $posts[0]->channelTitle }}</a>
    </h3>
    <div class="mb-sm-3">
      <script type="application/javascript" src="https://apis.google.com/js/platform.js"></script>
      <div class="g-ytsubscribe"  target="_blank"  data-channelid="{{$posts[0]->channel_id}}" data-layout="default" data-count="default"></div>
    </div>
    <div class="mb-sm-3">
      <a href="https://www.youtube.com/channel/{{ $posts[0]->channel_id }}" target="_blank">
        <button type="button" class="btn btn-danger" >Youtubeチャンネルに行く</button>
      </a>
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
          <a href="{{ route('posts.show',$post) }}" >{{ $post->title }}</a>
          
            <p class="card-text">{{ Str::limit($post->description,200) }}</p>
          
        </div>
      </div>
    </div>
    @endforeach
  </div>
  {{-- <div class="mx-auto" style="width: 200px;">
    {{ $posts->links() }}
  </div> --}}
</div>
@endsection
