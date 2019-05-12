<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function getPosts(Request $request ){
        //Get Posts
        $posts = Post::latest()->get();
        return [
            'status'=>200,
            'msg'=>"Posts ",
            'result'=>$posts
        ];
    }

    public function getPost(Request $request){

    }

    public function updatePost(Request $request , Post $id){
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);
        $post->update($request->only(['title', 'body']));
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
