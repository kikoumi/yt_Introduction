@extends('layouts.app')
@section('content')
<div class="container">
  @include('components.alert')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">動画編集</div>
        <div class="card-body">               
          <p>動画登録編集ページ</p>
          <form action="{{ route('posts.update',$post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input class="form-control" type="text" name="title" placeholder="タイトル" value="{{ $post->title }}">
            <div>
              <input type="text" class="form-control" name="tags" id="input_tags"  data-role="tagsinput" value="@foreach($post->tags as $tag){{$tag->name}},@endforeach"/>
            </div>
            <textarea class="form-control my-5" name="description" id="exampleFormControlTextarea1" rows="20">{{ $post->description }}</textarea>
            <a class="btn btn-primary" href="{{ route('posts.show',$post) }}">詳細に戻る</a>
            <button class="btn btn-primary" type="submit">登録する</button>
          </form>
          @if (isset(auth()->user()->role))
            @if(auth()->user()->role == 'owner' || \Auth::user()->id == $post->user_id)
              <form action="{{ route('posts.destroy',$post) }}" method="POST" >
                @method('DELETE')
                @csrf
                <button class="btn btn-danger mt-2">削除する</button>
              </form>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<script type="application/javascript" src="{{ asset('js/tagsinput.js') }}" defer></script>


@endsection