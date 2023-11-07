<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\MailForgetPassword;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function Register(Request $request){
        $request->validate([
            'name'=>'required|max:255|min:3',
            'user_name'=>'required|max:20|min:3|unique:users,user_name',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|max:20|min:6'
        ],
    [
        'name.required'=>'Nhập tên người dùng',
        'name.max'=> 'Tên người dùng không quá 255 kí tự',
        'name.min'=> 'Tên người dùng không dưới 3 kí tự',
        'user_name.required'=>'Nhập tên người dùng',
        'user_name.max'=> 'Tên người dùng không quá 20 kí tự',
        'user_name.min'=> 'Tên người dùng không dưới 3 kí tự',
        'user_name.unique'=> 'Tên người dùng đã tồn tại',
        'email.required'=>'Nhập email',
        'email.email'=>'Email không đúng định dạng',
        'email.unique'=>'Email đã tồn tại',
        'password.required'=>'Nhập mật khẩu',
        'password.max'=>'Mật khẩu không quá 20 kí tự',
        'password.min'=>'Mật khẩu không dưới 6 kí tự',
    ]);
        User::create([
            'name'=>$request->name,
            'user_name'=>$request->user_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'avatar' => 'http://localhost:8000/storage/img/users/default.png',
            'role'=>'1',

        ]);
        return response()->json(['status'=>200]);
    }
    public function Login(Request $request){
        $request->validate([
            'user_name'=>'required',
            'password'=>'required'
        ],[
            'user_name.required'=>'Nhập tên người dùng',
            'password.required'=>'Nhập mật khẩu',
        ]);

        $user_name=$request->user_name;
        $password=$request->password;
        if (Auth::attempt(['user_name' => $user_name, 'password' => $password])) {
            $user=auth()->user();
            return response()->json(['user'=>$user,'status'=>200]);
        }
        else {
            return response()->json(['status' => 401]);
        }
    }
    public function forgetPassword(Request $request){
        $request->validate([
            'email'=>'required'
        ],[
            'email.required'=>'Nhập email',
        ]);
        $email=$request->email;
        $user=User::where('email',$email)->first();
        if($user){
            $password=rand(100000,999999);
            $user->password = Hash::make($password);
            $user->save();
            Mail::to($email)->send(new MailForgetPassword($user->name,$password));
            return response()->json(['status'=>200]);
        }
        else{
            return response()->json(['status'=>401]);
        }
    }
    public function isAdmin(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => 'required',
            'password' => 'required'
        ],[
            'user_name.required'=>'Nhập tên người dùng',
            'password.required'=>'Nhập mật khẩu',
        ]
        );
        $user_name = $credentials['user_name'];
        $password = $credentials['password'];

        if (Auth::attempt(['user_name' => $user_name, 'password' => $password])) {
            $user = Auth::user();
            $role = $user->role;
            if ($role == 0) {
                return response()->json(['status' => 'success', 'admin' => $user]);
            } else {
                return response()->json(['status' =>'error']);
            }
        } else {
            return response()->json(['status' => 401]);
        }
    }
    public function profile(Request $request, $id){
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
            return response()->json(['user' => User::find($id), 'status' => 200]);
        }
    }


}
