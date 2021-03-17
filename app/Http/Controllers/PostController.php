<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $files = File::where('post_id', 1)->get();

        return response()->json([
            'id' => $post->id,
            'user_id' => $post->user_id,
            'post_title' => $post->post_title,
            'post_description' => $post->post_description,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'num_attachments' => $post->attachments,
            'files' => $files
        ], 200);
    }

    //This needs to be fixed
    public function getFile(Request $request) {
        $fileId = $request->id;
        $file = File::find($fileId);
        $fileNameArray = explode('/', $file->url);
        $contents = Storage::get(last($fileNameArray));
        return $contents;
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

    public function uploadFile(Request $request) {
        $postId = $request->postId;
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $validated = $request->validate([
                    'name' => 'string|max:40',
                    'image' => 'mimes:jpg,jpeg,png|max:90000',
                ]);

                $extension = $request->image->extension();
                $request->image->storeAs('/public', $validated['name'].".".$extension);
                $url = Storage::url($validated['name'].".".$extension);
                $file = File::create([
                    'post_id' => $postId,
                    'name' => $validated['name'],
                    'url' => $url
                ]);

                $post = Post::find($postId);
                if(isset($post)){
                    $post->increment('attachments');
                }
                $post->save();
                return true;
            }
            return false;
        }
        return false;
    }

    public function viewUploadsForPost (Request $request) {
        $postId = $request->postId;
        return File::where('post_id', 1)->get();
    }
}

