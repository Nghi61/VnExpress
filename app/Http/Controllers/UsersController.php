<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->role = ($user->role == 0 ? 'Quản lý' : 'Người dùng');
        }
        Crypt::encryptString(json_encode($users));
        return response()->json($users);
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
        $validated = $request->validate([
            'user_name' => 'required|unique:users,user_name|max:60|min:3',
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|max:30|min:6',
        ], [
            'user_name.required' => 'Nhập tên tài khoản',
            'user_name.unique' => 'Tên tài khoản đã tồn tại',
            'user_name.max' => 'Tên tài khoản không quá 255 ký tự',
            'user_name.min' => 'Tên tài khoản không dưới 3 ký tự',
            'name.required' => 'Nhập họ tên',
            'name.max' => 'Họ tên không quá 255 ký tự',
            'name.min' => 'Họ tên không dưới 3 ký tự',
            'email.required' => 'Nhập email',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Nhập mật khẩu',
            'password.confirmed' => 'Mật khẩu không trùng khớp',
            'password.max' => 'Mật khẩu không quá 30 ký tự',
            'password.min' => 'Mật khẩu không dưới 6 ký tự',
        ]);
        $user = User::create(
            [
                'user_name' => $request->user_name,
                'name' => $request->name,
                'email' => $request->email,
                'password' => hash::make($request->password),
                'role' => $request->role,
                'avatar' => $request->avatar,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_name' => 'required|max:255|min:3|unique:users,user_name,' . $id,
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
        ], [
            'user_name.required' => 'Nhập tên tài khoản',
            'user_name.unique' => 'Tên tài khoản đã tồn tại',
            'user_name.max' => 'Tên tài khoản không quá 255 ký tự',
            'user_name.min' => 'Tên tài khoản không dưới 3 ký tự',
            'name.required' => 'Nhập họ tên',
            'name.max' => 'Họ tên không quá 255 ký tự',
            'name.min' => 'Họ tên không dưới 3 ký tự',
            'email.required' => 'Nhập email',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email không hợp lệ',
        ]);
        User::find($id)->update([
            'user_name' => $request->user_name,
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $request->avatar,
            'role' => $request->role,
        ]);
        if ($request['changePassword'] == true) {
            $validated = $request->validate([
                'password' => 'required|confirmed|max:30|min:6',
            ], [
                'password.required' => 'Nhập mật khẩu',
                'password.confirmed' => 'Mật khẩu không trùng khớp',
                'password.max' => 'Mật khẩu không quá 30 ký tự',
                'password.min' => 'Mật khẩu không dưới 6 ký tự',
            ]);
        }
        User::find($id)->update([
            'password' => hash::make($request->password),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($name)
    {
        $user = User::where('user_name', $name)->get();
        $new = News::where('user_id', $user->id)->get();
        $comment = Comments::where('user_id', $user->id)->get();
        $new->delete();
        $comment->delete();
        $user->delete();
    }
    public function search(string $query)
    {
        $users = User::where('user_name', 'like', "%$query%")->get();
        foreach ($users as $user) {
            $user->role = ($user->role == 0 ? 'Quản lý' : 'Người dùng');
        }
        return response()->json($users);
    }
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $file->store('public/img/users');
        $response = [
            'file_path' => asset('storage/img/users/' . $file->hashName()), // Đường dẫn tệp
        ];
        return response()->json($response);
    }
}
