<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPost = Post::all()->sortByDesc('id');
        return view('dashboard', ["data" => $allPost]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('das');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postTitle = $request->title;
        $postContent = $request->content;
        $postMedia = $request->hasFile('media');
        $mediaType = $request->media->extension();
        $userId = Auth::user()->id;

        if ($request->hasFile('media')) {
            $newImageName = time() . '-' . $postTitle . '.' . $request->media->extension();

            if ($request->media->move(public_path('images'), $newImageName)) {
                $postMedia = $newImageName;
            }
        }

        $data = array('post_title' => $postTitle, "post_content" => $postContent, "post_media" => $postMedia, "user_id" => $userId, "media_type" => $mediaType);
        DB::table('posts')->insert($data);

        $allPost = Post::all()->sortByDesc('id');
        return view('dashboard', ["data" => $allPost]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $uid = Auth::user()->id;
        $myposts = DB::table('posts')->where('user_id', '=', "$uid")->get();

        return view('my-posts', ["data" => $myposts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Request $request)
    {
        Post::where('id', $request->id)->delete();

        $uid = Auth::user()->id;
        $myposts = DB::table('posts')->where('user_id', '=', "$uid")->get();

        return view('my-posts', ["data" => $myposts]);
    }
}
