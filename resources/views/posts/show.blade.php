@extends('layouts.app')
@section('content')

<div class="container">
  <div class="card">
    <div class="sizecheck">
      <div class="embed-responsive embed-responsive-16by9">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $post->url }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>


    <div class="card-body">
      <h4 class="card-title">{{ $post->title }}</h4>
      <div>
        @foreach ($post->tags as $tag)
      <a href="{{route('tags.show',$tag)}}" class="badge badge-pill badge-light" style="font-size:120%">{{ $tag->name }}</a>
        @endforeach
      </div>
      <div class="">
        <div class="text-left p-1 d-flex align-items-center">
          <a href="{{ route('channel.show',$post->channel_id) }}" class="pr-3">
            <img class="rounded-circle" src="{{ $post->channel_thumburl }}" alt="" style="width: 80px; height: 80px;">
          </a>

          <a href="{{ route('channel.show',$post->channel_id) }}" style="text-decoration: none;">
            <h4 class="font-weight-bold" style="color: #333; text-decoration: none;"> {{$post->channelTitle}}</h4>
          </a>
        </div>
        <div class="pt-3">
          <a class="btn btn-danger" target="_blank" href="https://www.youtube.com/watch?v={{ $post->url }}">Youtubeで見る</a>
          @if (isset(auth()->user()->role))
            @if (Auth::id() == $post->user_id||auth()->user()->role == 'owner')  
            <a class="btn btn-primary" href="{{ route('posts.edit',$post) }}">編集する</a>
            @endif
          @endif

          @guest
          <i class="far fa-heart  LikesIcon-fa-heart float-right mr-5" id="GuestLike" style="color:#333; font-size:30px; cursor : pointer;">{{ $defaultCount }}</i>
          
          
          @else
          <Like
          :post-id = "{{ json_encode($post->id) }}"
          :user-id = "{{ json_encode($viewuser->id) }}"
          :default-Liked="{{ json_encode($defaultLiked) }}"
          :default-Count="{{ json_encode($defaultCount) }}"
          >
          </Like>
          @endguest
        </div>
        @guest    
        <p class="float-right">いいねをするには<a href="{{ route('login') }}">ログイン</a>してください</p> 
        @endguest
        

      </div>
      <hr>
      <div>
        <h3><a href="{{ route('user.show',$postuser) }}">{{ $postuser->name }}</a>さんの紹介</h3>
      </div>
      <hr>
      {{-- <a class="btn btn-primary" target="_blank" href="https://www.youtube.com/watch?v={{ $post->url }}">Youtubeで見る</a> --}}
      <p class="card-text text-justify" id="description">
        {!! nl2br($post->description) !!}
      </p>
    </div>
  </div>
</div>
<script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="application/javascript">
  $(window).on('load resize', function() {
    var w = $(window).width();
    var x = 768;
    if (w <= x) {
      $('.sizecheck').addClass('sticky-top');
    }else if(w > x){
      $('.sizecheck').removeClass('sticky-top');
    }
  });

  $(function () {

    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    $('#description').html($('#description').html().replace(exp,"<a href='$1' target=_blank>$1</a>"));
});
$("#GuestLike").click(function(){
  $(this).slideUp();
});

</script>



@endsection
