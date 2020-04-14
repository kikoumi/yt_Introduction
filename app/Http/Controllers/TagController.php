<?php

namespace App\Http\Controllers;
use App\Post;
use App\Tag;
use Validator;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role == 'owner'){
            $tags =  Tag::orderBy('id', 'desc')->paginate(12);

            //ページネーション設定
            return view('tags.index',compact('tags'));
        }else{  
            return \App::abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //登録画面 ここでは登録画面だけなので送信するわけじゃない
    public function create()
    {
        if(auth()->user()->role == 'owner'){
            return view('tags.create');
        }else{  
            return \App::abort(404);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //タグを登録する際の処理
    public function store(Request $request)
    {
        if(auth()->user()->role == 'owner'){
            $rules = [
                'tag' => array('required','max:300'),  // 必須・文字列・２５５文字以内
               ];
               //|regex:/\?v=([^&]+)/
            $messages = [
                'url.required'   => 'タグが未入力です。',
                'url.max' => '300文字以上は入力できません'
                ];
            $validator = Validator::make($request->all(), $rules, $messages);
            $validated = $validator->validate();
               
             
               //dd($request->user());
               
            
            $tag = new Tag();
            $tag->name = $request->tag;
            
            $tag->save();
            return redirect()
            ->route('tags.index')
            ->with('status','タグを登録しました。')
            ->with(['validated'=>$validated]);
        }else{  
            return \App::abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $post
     * @return \Illuminate\Http\Response
     */
    //タグの検索結果 これは権限開放する
    public function show(Tag $tag)
    {
        //$post = Post::findOrFail($id);
        return view('tags.show',compact('tag'));
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $post
     * @return \Illuminate\Http\Response
     */
    //更新画面の表示のみ

    public function edit(Tag $tag)
    {
        //
        if(auth()->user()->role == 'owner'){
            return view('tags.edit',compact('tag'));
        }else{  
            return \App::abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        if(auth()->user()->role == 'owner'){
            $tag->name = $request->tag;
            $tag->update();

            return redirect()
            ->route('tags.index')
            ->with('status','タグ情報を更新しました。');
        }else{  
            return \App::abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
        if(auth()->user()->role == 'owner'){
            $tag->delete();
    
            return redirect()
            ->route('tags.index')
            ->with('status','タグを削除しました。');
        }else{  
            return \App::abort(404);
        }
    }
}
