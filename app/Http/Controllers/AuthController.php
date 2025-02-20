<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('user.signup');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
        ]);
    
        // Lưu email và mật khẩu vào session
        session([
            'registered_email' => $request->email,
            'registered_password' => $request->password
        ]);
    
        // Chuyển hướng đến trang đăng nhập với thông báo thành công
        return redirect()->route('login.form')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
    

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('user.login');
    }
}
