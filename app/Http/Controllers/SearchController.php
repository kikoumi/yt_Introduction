<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Post;
use App\Tag;
class SearchController extends Controller
{
    //
    public function search(Request $request){
        $search = $request->keyword;
        //動画タイトルで動画を取得(配列)
        $posts = Post::where('title', 'LIKE', "%{$search}%")->orWhere('description', 'LIKE', "%{$search}%")->get();
        //$posts = Post::where('title', 'LIKE' ,"%{$search}%")->orWhere();
        //dd($posts);
        //タグでタグIDを取得
        $tags = Tag::where('name', 'LIKE', "%{$search}%")->get();
        //dd($tags);
        //keywordを含むタグが1つ以上ある場合があるのでタグIDを配列にする タグ取得
        $tags_id = [];
        for($tags_cnt=0; $tags_cnt<count($tags); $tags_cnt++){
            array_push($tags_id, $tags[$tags_cnt]->id);
        }
        //dd($tags_id);
        

        $tag_new = new Tag;
        $get_tagpost = [];
        //タグIDから中間テーブル内の動画を取得
        for($tags_c=0; $tags_c<count($tags_id); $tags_c++){
            array_push($get_tagpost, $tag_new->find($tags_id[$tags_c])->posts);
        }
        //dd($get_tagpost[0]);

        //配列の規格を揃える タグ ここでタグに関する動画を全取得
        $get_tagset = [];
        for($tags_b=0; $tags_b<count($get_tagpost); $tags_b++){
            for($tags_a=0; $tags_a<count($get_tagpost[$tags_b]); $tags_a++){
                array_push($get_tagset,$get_tagpost[$tags_b][$tags_a]);
            }
        }
        //dd($get_tagset);

        //配列の規格を揃える ポスト
        $get_postset = [];
        for($post_b=0; $post_b<count($posts); $post_b++){
            array_push($get_postset,$posts[$post_b]);
        }
        
        //dd($get_postset);
        //とりあえずポストとタグを一つの配列にする
        $post_search = array_merge($get_tagset,$get_postset);
        //dd($post_search[9]->id);


        $key_posts = [];
        $key_check = [];
        $key_count2 = 0;
        //ポストとタグは配列の一つにまとめたので重複してるものは除去する
        for($post_count=0; $post_count<count($post_search); $post_count++){
            //とりあえず動画idを一つの配列に入れる
            array_push($key_check,$post_search[$post_count]->id);
            //被っていたら数は増えない 新規なら増える
            $key_count = count(array_unique($key_check));
            //以前の数を変わっていれば新規なのでその動画を取得
            if($key_count2 != $key_count){
                array_push($key_posts,$post_search[$post_count]);
            }
            //数が変われば新規の数に変える
            $key_count2 = $key_count;
        }
        //dd($key_check);
        //dd(count(array_unique($key_check)));  
        //dd($key_posts);
        //配列の中身はid順なので古い順になっている
        //新しい順にしたいので配列の中身を逆にして新しい順にする
        $key_post = array_reverse($key_posts);
        return view('posts.search',compact('search','key_post'));
        //ここからは動画IDが同じなら1つのみにするようなコードを書く
        //2020/01/31～
        //dd($get_tagpost[0][0]->id);
        //dd($get_tagpost);
        // dd(is_bool(count($posts)));
        // dd(count($posts));

        // $key_post = [];
        // //もしタイトルで無ければ
        // if(count($posts)==0){
        //     //タグでもない場合
        //     if(count($get_tagpost)==0){
        //         return true;
        //     }
        //     //タグはある場合
        //     else{
        //         // view側でkey_postという変数名にしたいので変更
        //         $key_post = $get_tagpost[0];
        //         //dd(count($key_post));
        //         return view('posts.search',compact('search','key_post'));
        //     }
        // }
        // //もしタグが無い場合
        // if(count($get_tagpost)==0){
        //     //もしタイトルでもない場合
        //     if(count($posts)==0){
        //         return true;
        //     }else{
        //         //タイトルである場合
        //         $key_post = $posts;
        //         //dd($key_post);
        //         return view('posts.search',compact('search','key_post'));
        //     }
        // }
        // //dd($get_tagpost[0]);
        // //dd($posts);
        // //どちらもある場合
        // if(count($posts)>0 && count($get_tagpost)>0){
        //     $key_post=[];
            
        //     for($post_count=0; $post_count<count($posts); $post_count++){
        //         for($tag_count=0; $tag_count<count($get_tagpost); $tag_count++){
                    
        //             //postのvideoIDとtagのvideoIDが同じなら
        //             //両方同じならどっち優先？　配列には入れるようにはする
        //             if($posts[$post_count]->id == $get_tagpost[0][$tag_count]->id){
        //                 array_push($key_post, $posts[$post_count]);
        //             }else{
        //                 //array_push($key_post, $get_tagpost[0][$tag_count]);
        //                 //array_push($key_post, $posts[$post_count]);
        //             }
                    
        //         }
        //     }
        //     //dd($key_post);
        //     return view('posts.search',compact('search','key_post'));
        // }
        
        
        // return view('posts.search',compact('search','key_post'));
    }

    
}
