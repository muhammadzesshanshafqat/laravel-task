<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $userId = $request->userId;
        $user = User::find($userId);

        if($user === null) {
            abort(404, "User does not exist");
        }

        // $isAuthenticated = Auth::id() === $userId;

        // if(!$isAuthenticated) {
        //     abort(401, "You are not authorised. Please login if you have an account or signup.");
        // }

        $postTitle = $request->postTitle;
        $postDescription = $request->postDescription;
        $numAttachments = $request->numAttachments;

        $post = Post::create([
            'user_id' => $userId,
            'post_title' => $postTitle,
            'post_description' => $postDescription,
            'attachments' => $numAttachments
        ]);

        return $post;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
        $postId = $request->postId;
        $post = Post::find($postId);
        return $post;
    }
      /**
     * Display posts for a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showAllForUser(Request $request) {
        $userId = $request->userId;
        $posts = Post::where('user_id', $userId)->get();
        return $posts;
    }
}
