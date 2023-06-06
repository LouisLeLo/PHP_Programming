<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $req)
    {
        // xử lí đăng nhập
        //dd($request->all());

        // Kiểm tra đăng nhập, Hàm "Auth::attemp" trả về true hoặc false
        if(Auth::attempt(['email'=>$req->email,'password'=>$req->password]))
        {
            return redirect(route('show.employee'));
        }
        else{
            session()->flash('message', 'Tên đăng nhập hoặc mật khẩu không đúng!');
            return redirect()->back();
        }
    }

    public function registerView(){
        return view('auth.register');
    }

    public function register(Request $req){       
        //Validate dữ liệu
        $req->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users',
            'password' => 'required|min:6|max:10|confirmed'
        ], [
            'name.required' => 'Họ và tên không được để trống',
            'name.regex' => 'Họ và tên sai định dạng',
            'email.required' => 'Email không được để trống',
            'email.regex' => 'Email sai định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Password không được để trống',
            'password.min' => 'Password không được ít hơn 6 kí tự',
            'password.max' => 'Password không được nhiều hơn 10 kí tự',
            'password.confirmed' => 'Password không     giống nhau'
        ]);

        //Để khi ta tương tác với db
        DB::beginTransaction();
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        //Mã hóa password qua mã Bcrypt
        $user->password = Hash::make($req->password) ;        
        $user->save();   
        $user->assignRole('user');
        session()->flash('success', 'Chúc mừng bạn đã đăng ký thành công, mời bạn đăng nhập!');
        DB::commit();
        return view('auth.login');
    }
}
