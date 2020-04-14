@extends('layouts.app')
@section('content')
<div class="container">
  @include('components.alert')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">動画登録</div>

                <div class="card-body">
                  <div  style="margin-left: 0px">
                    <p style="">動画登録ページ</p>
                  </div>
                    <p class="font-weight-bold">API使用するため、1分に1回の制限を掛けてます。</p>
                  <div>
                    <p class="text-left badge-pill badge-danger" style="float: left ">制限中</p>
                    {{-- {{ dd($exception->getHeaders()['X-RateLimit-Reset']) }} --}}
                    {{-- 前回はここでクッキーを保存していたが、
                    エラー画面になるまでクッキーセットできないので
                    postしたタイミングにクッキーを保存するようにする --}}
                    {{-- {{ \Cookie::queue('limit',1,1) }}
                    {{ \Cookie::queue('limit-time',$exception->getHeaders()['X-RateLimit-Reset'], 1) }} --}}
                    
                    {{-- {{ setcookie('limit') }}
                    {{ setcookie('limit-time') }} --}}

                    <p class="text-right">制限解除時刻:{{ date('Y/m/d H:i:s',$exception->getHeaders()['X-RateLimit-Reset']) }}</p>
                  </div>    

                    
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @if ($errors->has('url'))
                      <span class="invalid-feedback">{{ $errors->first('url') }}</span>
                      @endif
                      <input class="form-control" type="text" name="url" placeholder="URLを入力してください" value="{{old('url')}}">
                      @if ($errors->has('url'))
                        <span class="text-danger">{{$errors->first('url')}}</span>
                      @endif
                      <div class=btn-group-toggle>
                        <a class="btn btn-primary mt-2" href="{{ route('posts.index') }}">一覧に戻る</a>
                        <button class="btn btn-primary mt-2" type="submit">登録する</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection