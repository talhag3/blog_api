<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function getPosts(Request $request ){
        //Get Posts
        $posts = Post::orderBy('updated_at','DESC')->paginate()->toarray();
        
        $result['posts'] = $posts['data'];
        unset($posts['data']);
        $result['pagination']=$posts;
        
        return [
            'status'=>200,
            'msg'=>"Posts ",
            'result'=>$result
        ];
    }

    public function getPost(Request $request,Post $post){
        //$post->likes;
        $post->likes()->count();  
        return [
            'status'=>200,
            'msg'=>"Post",
            'result'=>$post,
        ];
    }

    public function getPost2(Request $request,$id){
        $post = Post::where('id',$id);
        $post->with(['user']);
        $post->withCount(['likes']);
        $post->with(['likes'=>function($query){
            $query->select('like_posts.id AS user_id','name as user_name');
        }]);
        return $post->get();
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

    public function deletePost(Request $request,Post $post){

        $post->delete();
        //User::destroy([1, 2, 3]);
        return [
            'status'=>200,
            'msg'=>"Post Deleted ",
            'result'=>true
        ];
    }

    public function likePost(Request $request,Post $post){
        $user_id = $request->me->id;
        //$post->likes()->create(['user_id'=>$user_id]);
        $post->likes()->sync([$user_id]);
        //$post->likes()->toggle([$user_id]);
        //$post->likes()->detach([$user_id]);
        //$post->likes()->attach($request->me);
        return [
            'status'=>200,
            'msg'=>"Post Liked",
            'result'=>true
        ];
    }

    public function unLikePost(Request $request,Post $post){
        $post->likes()->toggle([$request->me->id]);
        return [
            'status'=>200,
            'msg'=>"Post UnLiked",
            'result'=>true
        ];
    }

    public function postLikes(Request $request,Post $post){
        return $post->likes;
    }
}
