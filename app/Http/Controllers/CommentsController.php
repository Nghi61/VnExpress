<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = DB::table('comments')
            ->join('news', 'comments.news_id', '=', 'news.id') // Đã sửa
            ->join('users', 'comments.user_id', '=', 'users.id') // Đã sửa
            ->select('users.user_name', 'news.title', 'comments.*')
            ->get();
        foreach ($comments as $comment) {
            $comment->created_at = date('d-m-Y', strtotime($comment->created_at));
        }
        return response()->json($comments);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = new Comments();
        $comment->user_id = $request->user_id;
        $comment->news_id = $request->news_id;
        $comment->content = $request->content;
        $comment->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comments::destroy($id);
    }
    public function search(string $query)
    {
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->select('users.user_name', 'comments.*')
            ->where('users.user_name', 'like', '%' . $query . '%')
            ->get();
        foreach ($comments as $comment) {
            $comment->created_at = date('d-m-Y', strtotime($comment->created_at));
        }
        return response()->json($comments);
    }
    public function getComment($id){
        $comments=db::table('comments')
            ->join('users','comments.user_id','=','users.id')
            ->select('users.name','users.avatar','comments.*')
            ->orderBy('id','desc')
            ->where('comments.news_id','=',$id)
            ->get();
        foreach ($comments as $comment) {
            $comment->created_at = date('d-m-Y', strtotime($comment->created_at));
        }
        return response()->json($comments);
    }
}
