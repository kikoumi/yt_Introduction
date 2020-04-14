<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PostController extends Controller
{

    public function __construct() 
    {
        // 「特定のメソッドだけ」
        //1分に60回の送信までに制限
        $this->middleware('throttle:1,1')->only(['store']);  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //すべてのPostを取得する
        $posts =  Post::orderBy('created_at', 'desc')->paginate(12);
        // dd($posts->channelTitle);
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //登録画面
    public function create()
    {
        if (Auth::check()) {
            return view('posts.create');
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
    //登録時処理　API叩いてるので取り扱い注意
    public function store(Request $request)
    {
        if (Auth::check()) {
            //1分制限をクライアント側でもクッキーとして持ってもらう
             Cookie::queue('limit',1,1);
             Cookie::queue('limit-time',time() + 60, 1);

            $rules = [
                'url' => array('required','regex: /(?:youtube\.com\/\S*(?:(?:\/e(?:mbed))?\/|watch\?(?:\S*?&?v\=))|youtu\.be\/)([a-zA-Z0-9_-]{6,11})/'),  // 必須・文字列・２５５文字以内
               ];
               
            $messages = [
                'url.required'   => 'URLが未入力です。',
                'url.regex' => 'YoutubeのURLではありません。'
                ];
            $validator = Validator::make($request->all(), $rules, $messages);
            $validated = $validator->validate();
               
               
            
               
            $url = $request->url;
            preg_match_all('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $url, $match);
            $id = $match[0];
            $id_str = $id[0];
    
            $response = file_get_contents('https://www.googleapis.com/youtube/v3/videos?id='.$id_str.'&key='.env('YOUTUBE_API').'&part=snippet');
            $result = json_decode($response,true);
            //dd($result['items'][0]['snippet']['thumbnails']['standard']['url']);
            //dd($result);
            //dd($result['items'][0]['snippet']['tags']);
            
            //dd($tags);

            //channelID
            $channelID = $result['items'][0]['snippet']['channelId'];

            //channelTitle
            $ChTitle = $result['items'][0]['snippet']['channelTitle'];

            

            //dd(Post::where('channel_id', 'LIKE', "%{$channelID}%")->get());
            //dd($result['items'][0]['snippet']['channelTitle']);
            $video = new Post();
            $video->user_id = $request->user()->id;
            $channelpost = Post::where('channel_id', 'LIKE', "%{$channelID}%")->get();
            //もしそのチャンネルが登録してなければ登録する、あれば既存のものから取得(チャンネルサムネ取得)
            if(count($channelpost) == 0){
                $video->channel_id = $channelID;
                $video->channelTitle = $ChTitle;
                $Chresponse = file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=snippet&id='.$channelID.'&key='.env('YOUTUBE_API'));
                $Chresult = json_decode($Chresponse,true);
                //dd($Chresult);
                //もしhighサイズなければmediumサイズ取得それでもなければdefaultサイズ
                if(isset($Chresult['items'][0]['snippet']['thumbnails']['high']['url']))
                {
                    $video->channel_thumburl = $Chresult['items'][0]['snippet']['thumbnails']['high']['url'];
                }else if(isset($Chresult['items'][0]['snippet']['thumbnails']['medium']['url']))
                {
                    $video->channel_thumburl = $Chresult['items'][0]['snippet']['thumbnails']['medium']['url'];
                }else{
                    $video->channel_thumburl = $Chresult['items'][0]['snippet']['thumbnails']['default']['url'];
                }
            }else{
                $video->channel_id = $channelpost[0]['channel_id'];
                $video->channelTitle = $channelpost[0]['channelTitle'];
                $video->channel_thumburl = $channelpost[0]['channel_thumburl'];
            }
            //dd($result['items'][0]['snippet']['thumbnails']['high']['url']);
            //$video->tags()->attach($)
            $video->url = $id_str;
            //サムネ取得で大きいサイズなければ小さいものを取得するようにする
            //ビデオのサムネ取得
            if(isset($result['items'][0]['snippet']['thumbnails']['standard']['url'])){
                $video->thumburl = $result['items'][0]['snippet']['thumbnails']['standard']['url'];
            }
            else if(isset($result['items'][0]['snippet']['thumbnails']['high']['url'])){
                $video->thumburl = $result['items'][0]['snippet']['thumbnails']['high']['url'];
            }
            else if(isset($result['items'][0]['snippet']['thumbnails']['midium']['url'])){
                $video->thumburl = $result['items'][0]['snippet']['thumbnails']['high']['url'];
            }
            else{
                $video->thumburl = $result['items'][0]['snippet']['thumbnails']['default']['url'];
            }
            $video->title = $result['items'][0]['snippet']['title'];
            $video->description = $result['items'][0]['snippet']['description'];
            $video->save();
            //dd($tags);
            $tag_list = [];
            if(isset($result['items'][0]['snippet']['tags'])){
                $tags = $result['items'][0]['snippet']['tags'];
                foreach ($tags as $tag) {
                    $record = Tag::firstOrCreate(['name' => $tag]);//新規タグを登録　すでに在るのは登録しない。
        
                    array_push($tag_list, $record);//既存タグと新規タグは$tag_list配列にまとめる tagsは既に配列があるので新規配列作成した
                };
            }
            //dd($tag_list[0]['id']);
            //タグのidを配列化させる
            $tags_id = [];
            for($tagc=0;$tagc<count($tag_list); $tagc++){
                array_push($tags_id, $tag_list[$tagc]['id']);
            };
            //dd($tags_id); 
            
            $video->tags()->attach($tags_id);
            
            
            //$video->Tags()->attach($tags_id);
            
            return redirect()
            ->route('posts.index')
            ->with('status','動画を登録しました。')
            ->with(['validated'=>$validated]);
        }else{  
            return \App::abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        if (Auth::check()){
            $viewuser = \Auth::user();
    
            $post->load('likes');
    
            //likeの初期値
            $defaultCount = count($post->likes);
            // dd(count($post->likes));
            // dd(count($post->likes));
            // dd($post::find(1)->likes());
            // 現在ユーザーがいいねを押しているか
            $defaultLiked = $post->likes->where('user_id', $viewuser->id)->first();
            //dd($defaultLiked);
            if($defaultLiked == null) {
                $defaultLiked == false;
            } else {
                $defaultLiked == true;
            }
            
            $postuser = User::find($post->user_id);
            
            return view('posts.show',['post' => $post ,'postuser' => $postuser, 'viewuser' => $viewuser,'defaultLiked' => $defaultLiked,'defaultCount' => $defaultCount]);
        }else{
            $postuser = User::find($post->user_id);
            $defaultCount = count($post->likes);
            return view('posts.show',['post' => $post ,'postuser' => $postuser, 'defaultCount' => $defaultCount]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    //更新画面の表示のみ
    public function edit(Post $post)
    {
        
        //投稿した人のみ編集可にする

        if (Auth::check()&&Auth::id() == $post->user_id) {
            $tags = Tag::pluck('name','id')->toArray();
            return view('posts.edit',compact('post','tags'));
        }else if(Auth::check()&&auth()->user()->role == 'owner'){
            $tags = Tag::pluck('name','id')->toArray();
            return view('posts.edit',compact('post','tags'));
        }
        else{  
            return \App::abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        
        //カンマ区切りなのでこれで配列にする(タグ)
        if (Auth::check()) {
            $match=explode(',',$request['tags']);
            //dd($match);
            $tag_list = [];
            foreach ($match as $tag) {
                $record = Tag::firstOrCreate(['name' => $tag]);
                array_push($tag_list, $record);
            };
            //dd($tag_list);
    
            // 投稿に紐付けされるタグのidを配列化
            $tags_id = [];
            for($tagc=0;$tagc<count($tag_list); $tagc++){
                array_push($tags_id, $tag_list[$tagc]['id']);
            };
            //dd($tags_id);
            //編集した人のid保存するようにする
            $post->user_id = Auth::id(); 
            $post->url = $post->url;
            $post->title = $request->title;
            $post->description = $request->description;

            $post->update();
            //既に登録してるIDを一度全削除後、新規で新たにタグ追加
            $post->tags()->detach();
            $post->tags()->attach($tags_id);
            return redirect()
            ->route('posts.index')
            ->with('status','動画情報を更新しました。');
        }else{  
            return \App::abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //owner権限か投稿ユーザのみ削除可能
        if(auth()->user()->role == 'owner'||\Auth::user()->id == $post->user_id){
            $post->delete();
            return redirect()
            ->route('posts.index')
            ->with('status','動画を削除しました。');
        }else{  
            return \App::abort(404);
        }
    }
}
