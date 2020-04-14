@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">タグ編集</div>
                    <div class="card-body">
                        @include('components.alert')
                        <form method="POST" action="{{ route('tags.update', $tag) }}">
                            @method('PUT')
                            @csrf
                        <input class="form-control" type="text" name="tag" placeholder="タグを入力してください" value="{{ $tag->tag }}">
                        <a class="btn btn-primary mt-2" href="{{ route('tags.index') }}">一覧に戻る</a>
                        <button class="btn btn-primary mt-2" type="submit">登録する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection