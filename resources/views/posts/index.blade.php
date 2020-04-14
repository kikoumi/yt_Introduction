@extends('layouts.app')
@section('content')
<div class="container">
  @include('components.alert')
  <form action="/search" method="GET">
    <div class="row">
        <div class="col">
          <input type="text" name="keyword" class="form-control" placeholder="サイト内検索">
        </div>
        <button type="submit" class="btn btn-primary">検索</button>
    </div>
  </form>
  <div class="row row-cols-1 row-cols-md-3">
    @foreach ($posts as $post)
    <div class="col mb-4">
      <div class="card h-100">
        <a href="{{ route('posts.show',$post) }}">
          <img class="card-img-top" src="{{ $post->thumburl }}" alt="">
        </a>
        <div class="card-body">
          <a href="{{ route('posts.show',$post) }}" style=" color: black">{{ $post->title }}</a>
          <a href="{{ route('channel.show',$post->channel_id) }}" style=" color: black">
            <p class="card-text mt-2">{{ $post->channelTitle}}</p>
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="mx-auto text-center" style="width: 200px;">
    {{ $posts->links() }}
  </div>
</div>
<script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="application/javascript">
$(function () {
    $('.pagination').css('justify-content','center');
});
</script>
@endsection