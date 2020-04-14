@extends('layouts.app')
@section('content')
<div class="container">
  @include('components.alert')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">タグ登録</div>

                <div class="card-body">               
                    <p>タグ登録ページ</p>
                    <form action="{{ route('tags.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @if ($errors->has('tag'))
                      <span class="invalid-feedback">{{ $errors->first('tag') }}</span>
                      @endif
                      <input class="form-control" type="text" name="tag" placeholder="タグを入力してください" value="{{old('tag')}}">
                      @if ($errors->has('tag'))
                        <span class="text-danger">{{$errors->first('tag')}}</span>
                      @endif
                      <div class=btn-group-toggle>
                        <a class="btn btn-primary mt-2" href="{{ route('tags.index') }}">一覧に戻る</a>
                        <button class="btn btn-primary mt-2" type="submit">登録する</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection