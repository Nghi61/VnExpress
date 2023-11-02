<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cate = Category::where('id', '!=', 1)->get();
        return response()->json($cate);
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
        $validated = $request->validate(
            [
                'name' => 'required|unique:category,name|max:255|min:3',
                'slug' => 'required|unique:category,slug|regex:/^[a-z0-9-]+$/|max:255|min:3',
            ],
            [
                'name.required' => 'Nhập tên danh mục',
                'name.unique' => 'Tên danh mục đã tồn tại',
                'name.max' => 'Tên danh mục không quá 255 ký tự',
                'name.min' => 'Tên danh mục không dưới 3 ký tự',
                'slug.required' => 'Nhập slug',
                'slug.unique' => 'Slug đã tồn tại',
                'slug.regex' => 'Slug không được có ký tự đặc biệt',
                'slug.max' => 'Slug không quá 255 ký tự',
                'slug.min' => 'Slug không dưới 3 ký tự',
            ]
        );

        if ($validated) {
            $cate = new Category();
            $cate->name = $request->name;
            $cate->slug = $request->slug;
            $cate->save();
            $cate->refresh();
            $name = $cate->name;
            $slug = $cate->slug;
            return response()->json([
                'cate' => [
                    'id' => $cate->id,
                    'name' => $name,
                    'slug' => $slug,
                ],
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        return response()->json($category);
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
        $validated = $request->validate(
            [
                'name' => 'required|max:255|min:3|unique:category,name,' . $id,
                'slug' => 'required|max:255|min:3|regex:/^[a-z0-9-]+$/|unique:category,slug,' . $id,
            ],
            [
                'name.required' => 'Nhập tên danh mục',
                'name.unique' => 'Tên danh mục đã tồn tại',
                'name.max' => 'Tên danh mục không quá 255 ký tự',
                'name.min' => 'Tên danh mục không dưới 3 ký tự',
                'slug.required' => 'Nhập slug',
                'slug.unique' => 'Slug đã tồn tại',
                'slug.regex' => 'Slug không được có ký tự đặc biệt',
                'slug.max' => 'Slug không quá 255 ký tự',
                'slug.min' => 'Slug không dưới 3 ký tự',
            ]
        );

        if ($validated) {
            $cate = Category::find($id);
            $cate->name = $request->name;
            $cate->slug = $request->slug;
            $cate->save();
            $cate->refresh();
            return response()->json($cate);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $name)
    {
        $category = Category::where('name', $name)->get();
        $news = News::where('category_id', $category->id)->get();
        foreach ($news as $new) {
            $new->update([
                'category_id' => 1
            ]);
        }
        $category->delete();
    }
    public function search(string $query)
    {
        $category = Category::where('name', 'like', "%$query%")->get();
        return response()->json($category);
    }
}
