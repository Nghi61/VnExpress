<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = DB::table('news')->join('category', 'news.category_id', '=', 'category.id')->select('news.*', 'category.name as category_name')->orderBy('id','desc')->get();
        foreach ($news as $new) {
            $new->created_at = date('d-m-Y', strtotime($new->created_at));
        }

        return response()->json($news);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:news,title|max:255|min:10',
            'slug' => 'required|max:255|min:3|regex:/^[a-z0-9-]+$/|unique:news,slug',
            'category' => 'required',
            'image' => 'required',
            'description' => 'required',
            'content' => 'required',
        ], [
            'title.required' => 'Nhập tiêu đề',
            'title.unique' => 'Tiêu đề đã tồn tại',
            'title.max' => 'Tiêu đề không quá 255 ký tự',
            'title.min' => 'Tiêu đề không dưới 10 ký tự',
            'slug.required' => 'Nhập slug',
            'slug.unique' => 'Slug đã tồn tại',
            'slug.regex' => 'Slug không được có ký tự đặc biệt',
            'slug.max' => 'Slug không quá 255 ký tự',
            'slug.min' => 'Slug không dưới 3 ký tự',
            'category.required' => 'Chọn danh mục',
            'image.required' => 'Vui lòng chọn ảnh',
            'description.required' => 'Nhập mô tả',
            'content.required' => 'Nhập nội dung',
        ]);
        $news = News::create(
            [
                'title' => $request->title,
                'slug' => $request->slug,
                'category_id' => $request->category,
                'image' => $request->image,
                'description' => $request->description,
                'user_id' => $request->user_id,
                'view' => 0,
                'content' => $request->content,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::find($id);
        return response()->json($news);
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
        $validated = $request->validate([
            'title' => 'required|max:255|min:10|unique:news,title,' . $id,
            'slug' => 'required|max:255|min:3|regex:/^[a-z0-9-]+$/|unique:news,slug,' . $id,
            'category' => 'required',
            'description' => 'required',
            'content' => 'required',
        ], [
            'title.required' => 'Nhập tiêu đề',
            'title.unique' => 'Tiêu đề đã tồn tại',
            'title.max' => 'Tiêu đề không quá 255 ký tự',
            'title.min' => 'Tiêu đề không dưới 10 ký tự',
            'slug.required' => 'Nhập slug',
            'slug.unique' => 'Slug đã tồn tại',
            'slug.regex' => 'Slug không được có ký tự đặc biệt',
            'slug.max' => 'Slug không quá 255 ký tự',
            'slug.min' => 'Slug không dưới 3 ký tự',
            'category.required' => 'Chọn danh mục',
            'description.required' => 'Nhập mô tả',
            'content.required' => 'Nhập nội dung',
        ]);
        $news = News::find($id);
        $news->update(
            [
                'title' => $request->title,
                'slug' => $request->slug,
                'category_id' => $request->category,
                'image' => $request->image,
                'description' => $request->description,
                'user_id' => $request->user_id,
                'content' => $request->content,
            ]
        );
        if ($request->image) {
            $news->image = $request->image;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $new = News::where('id', $id)->first();
        $comment = Comments::where('news_id', $new->id)->get();
        foreach ($comment as $cmt) {
            $cmt->delete();
        }
        $new->delete();
    }
    public function search(string $query)
    {
        $news = News::where('title', 'like', "%$query%")->get();
        foreach ($news as $new) {
            $new->created_at = date('d-m-Y', strtotime($new->created_at));
        }
        return response()->json($news);
    }
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $file->store('public/img/news');
        $response = [
            'file_path' => asset('storage/img/news/' . $file->hashName())
        ];
        return response()->json($response);
    }
    public function NewsBySlug(string $slug)
    {
        $news = DB::table('news')
            ->join('category', 'news.category_id', '=', 'category.id')
            ->select('news.*', 'category.name as category_name', 'category.slug as category_slug')
            ->where('category.slug', $slug)
            ->get();

        // Use Carbon for date formatting
        foreach ($news as $new) {
            $new->created_at = Carbon::parse($new->created_at)->format('d-m-Y');
        }
            return response()->json($news);
    }

}
