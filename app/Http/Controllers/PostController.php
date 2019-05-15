<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function getPosts(Request $request ){
        //Get Posts
        $posts = Post::orderBy('updated_at','DESC')->get();
        return [
            'status'=>200,
            'msg'=>"Posts ",
            'result'=>$posts
        ];
    }

    public function getPost(Request $request,Post $post){
        return [
            'status'=>200,
            'msg'=>"Post",
            'result'=>$post
        ];
    }

    public function updatePost(Request $request , Post $post){
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return [
            'status'=>200,
            'msg'=>"Post Updated ",
            'result'=>$post
        ];
    }

    public function createPost(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            //'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $post = new Post();
        $post->title = $request->title;
        $post->user_id = $request->me->id;
        $post->body=$request->body;
        $post->save();

        return [
            'status'=>200,
            'msg'=>"Post Created ",
            'result'=>$post
        ];
    }

    public function deletePost(Request $request){

    }
}
