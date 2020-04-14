@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row row-cols-1 row-cols-md-3">
    @foreach ($channels as $channel)
    <div class="col-sm-6 col-md-3">
      <div class="h-100">
        <a href="{{ route('channel.show',$channel->channel_id) }}">
          <img class="card-img-top rounded-circle" src="{{ $channel->channel_thumburl }}" alt="">
        </a>
        {{-- </div> --}}
        <div class="card-body text-center">
          <a href="{{ route('channel.show',$channel->channel_id) }}" class="">{{ $channel->channelTitle }}</a>
        </div>
        <div class="text-center mb-4">
          <a href="{{ route('channel.show',$channel->channel_id) }}" class="text-center mb-4">
            <button type="button" class="btn btn-primary">詳細ページ</button>
          </a>
        </div>
          {{-- <p class="card-text">{{ Str::limit($post->description,200) }}</p> --}}

      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection