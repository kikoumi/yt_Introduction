<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\like;

class LikeController extends Controller
{
    //

    public function like(Post $post, Request $request)
    {
        
      $like = like::create(['user_id' => $request->user_id , 'post_id' => $post->id]);
      $likeCount = count(Like::where('post_id', $post->id)->get());

      return response()->json(['likeCount' => $likeCount]);
    }

    public function unlike(Post $post, Request $request)
    {
      $like = Like::where('user_id', $request->user_id)->where('post_id', $post->id)->first();
      $like->delete();

      $likeCount = count(Like::where('post_id', $post->id)->get());

      return response()->json(['likeCount' => $likeCount]);
    }

    public function LikePosts()
    {
      $viewuser = \Auth::user();
      //dd($viewuser->id);
       $likeposts = Like::where('user_id', $viewuser->id)->get();
       //dd($likeposts);
       $getposts = [];
            
       foreach($likeposts as $likepost){
        //dd($likepost->post_id);
        array_push($getposts,$likepost->post_id);
       }
       //dd($getposts);
       $posts = Post::whereIn('id', $getposts)->get();
       //dd($posts);

       return view('likes.index',compact('posts'));
    }
  
      
}