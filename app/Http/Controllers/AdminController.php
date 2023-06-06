<?php

namespace App\Http\Controllers;

use App\Mail\MyTestMail;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\File as File;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function TaiGame(){        
        return view('tai-game');
    }

    public function TinhTong(Request $reg){
        $a = $reg->a;
        $b = $reg->b;
        $c = $a + $b;
        // dd($c);
        return view('ket-qua', compact('c'));
    }

    //Show Danh sách employee
    public function ShowDanhSachEmployee(Request $req){
        //$employees = Employee::all() gọi tới static function query tất cả trong db
        $tukhoa = $req->tukhoa;
        $employees = Employee::where('gioitinh', 'like', '%'.$tukhoa.'%')->orWhere('ngaysinh', 'like', '%'.$tukhoa.'%')->orWhere('diachi', 'like', '%'.$tukhoa.'%')->orWhere('hoten', 'like', '%'.$tukhoa.'%');
        $employees = $employees->orderBy('dtb','desc');

        $req->rows != null ? $employees = $employees->paginate($req->rows) : $employees = $employees->paginate(10);
        
        $departments = Department::all();
        
        return view('show-danh-sach-employee', compact('employees', 'departments'));
    }

    public function CreateEmployee(Request $reg){
        // $hoten = $reg -> hoten;
        // $gioitinh = $reg -> gioitinh;
        // $ngaysinh = $reg -> ngaysinh;
        if($reg -> method() == 'GET'){
            $departments = Department::all();
            return view('create-employee', compact('departments'));
        }else{
            DB::beginTransaction();
            $reg -> validate([
                'avatar' => 'nullable|image|mimes:jpg,png,jpeg',
                'hoten' => 'required|regex:/^[a-zA-Z\s]*$/',
                'gioitinh' => 'in:nam,nu,khac',
                'ngaysinh' => 'date|required',
                'dtb' => 'numeric|min:0|max:10|required',                
            ], [
                'avatar.image' => 'File tải lên phải là ảnh',
                'avatar.mimes' => 'File ảnh phải có đuôi là jpg, png or jpeg',
                'hoten.required' => 'Họ tên không được để trống',
                'hoten.regex' => 'Họ tên sai định dạng',
                'gioitinh.in' => 'Giới tính phải là nam, nữ hoặc khác',
                'ngaysinh.date' => 'Ngày sinh sai định dạng',
                'ngaysinh.required' => 'Ngày sinh không được để trống',
                'dtb.numeric' => 'Điểm trung bình sai định dạng',
                'dtb.required' => 'Điểm trung bình không được để trống',
                'dtb.min' => 'Điểm trung bình không được không được nhỏ hơn 0',
                'dtb.max' => 'Điểm trung bình không được vượt quá 10',
            ]);

            //dd($reg -> all());
            $input = $reg -> all();
            if($reg->has('avatar')){
                $file = $reg->file('avatar');
                $file_extension = $file -> getClientOriginalName();
                $destination_path = public_path().'/uploads/';
                //dd($destination_path);
                $filename = $file_extension;
                //dd($filename);
                $reg -> file('avatar')->move($destination_path, $filename);
                $input['avatar'] = $filename;
                $path = 'uploads/'.$filename;                       
                $file = new File();
                $file -> ten_file = $filename;
                $file -> url = $path;      
                $file -> save();
            }
            
            $employee = new Employee();
            $employee -> hoten = $reg -> hoten;
            $employee -> gioitinh = $reg -> gioitinh;
            $employee -> ngaysinh = $reg -> ngaysinh;
            $employee -> dtb = $reg -> dtb;
            $employee -> diachi = $reg -> diachi;
            $employee -> department_id = $reg -> department_id;
            $employee -> avatar_id = $file -> id;
            $employee -> save();

            //Sau khi tạo mới xong thì thực hiện việc gửi email
            $details = [
                'title' => 'Mail từ admin',
                'body' => 'Chào mừng bạn đến với kỹ nguyên vô tận ^_^'
            ];
            Mail::to('boybet97@yahoo.com')->send(new MyTestMail($details));
            
            session()->flash('success', 'Chúc mừng bạn đã tạo mới thành công');
            //"redirect()->back()" Trả về trang đã gửi submit(yêu cầu)
            DB::commit();
            return redirect()->back();
            //dd($reg -> all());
        }
    }    
    
    public function EditEmployee(Request $reg, $id){
        if($reg -> method() == 'GET'){
            //Tìm đến đối tượng muốn update
            $employee = Employee::findOrFail($id);

            //Điều hướng đến view 'edit-employee' và truyền sang dữ liệu về Employee muốn sửa đổi
            return view('edit-employee', compact('employee'));
        }else{
            $reg -> validate([
                'avatar' => 'nullable|image|mimes:jpg,png,jpeg',
                'hoten' => 'required|regex:/^[a-zA-Z\s]*$/',
                'gioitinh' => 'in:nam,nu,khac',
                'ngaysinh' => 'date|required',
                'dtb' => 'numeric|min:0|max:10|required',
            ], [
                'avatar.image' => 'File được chọn phải là ảnh',
                'avatar.mimes' => 'File ảnh phải có đuôi là jpg, png or jpeg',
                'hoten.required' => 'Họ tên không được để trống',
                'hoten.regex' => 'Họ tên sai định dạng',
                'gioitinh.in' => 'Giới tính phải là nam, nữ hoặc khác',
                'ngaysinh.date' => 'Ngày sinh sai định dạng',
                'ngaysinh.required' => 'Ngày sinh không được để trống',
                'dtb.numeric' => 'Điểm trung bình sai định dạng',
                'dtb.required' => 'Điểm trung bình không được để trống',
                'dtb.min' => 'Điểm trung bình không được không được nhỏ hơn 0',
                'dtb.max' => 'Điểm trung bình không được vượt quá 10',
            ]);

            //Tìm đến đối tượng muốn update
            $employee = Employee::findOrFail($id);

            $input = $reg -> all();
            if($reg->has('avatar')){
                $file = $reg->file('avatar');
                $file_extension = $file -> getClientOriginalName();
                $destination_path = public_path().'/uploads/';
                //dd($destination_path);
                $filename = $file_extension;
                //dd($filename);
                $reg -> file('avatar')->move($destination_path, $filename);
                $input['avatar'] = $filename;
                $path = 'uploads/'.$filename;                       
                $file = new File();
                $file -> ten_file = $filename;
                $file -> url = $path;      
                $file -> save();
            }

            $employee->hoten = $reg->hoten;
            $employee->gioitinh = $reg->gioitinh;
            $employee->ngaysinh = $reg->ngaysinh;
            $employee->dtb = $reg->dtb;
            $employee->diachi = $reg->diachi;
            $employee -> avatar_id = $file -> id;
            $employee->save();
            session()->flash('success', 'Chúc mừng bạn đã cập nhật thành công');
            return redirect()->route('show.employee');
        }
    }
    
    public function DeleteEmployee($id){
        $employee = Employee::findOrFail($id);
        $employee->delete();
        session()->flash('success', 'Chúc mừng bạn đã xóa thành công');
        return redirect()->route('show.employee');
    }

    public function SearchEmployee(Request $reg){
        $tukhoa = $reg->tukhoa;
        $employees = Employee::where('gioitinh', 'like', '%'.$tukhoa.'%')->orWhere('ngaysinh', 'like', '%'.$tukhoa.'%')->orWhere('diachi', 'like', '%'.$tukhoa.'%')->orWhere('hoten', 'like', '%'.$tukhoa.'%')->get();
        return view('show-danh-sach-employee', compact('employees'));
    }

    public function ExportEmployee(Request $reg)
    {
        //dd($reg->all());
        
        //Tìm trong "Employee" thằng có id là "$reg->ids". where là truyển chuỗi, whereIn là truyền 1 mảng
        //Hàm "explode()" chuyển chuỗi thành mảng, (1, 5)-> explode(",",$reg->ids), (1. 5)-> explode(".",$reg->ids)
        $employees = Employee::whereIn('id', explode(",",$reg->ids))->get();
        dd($employees);

        //$employee = Employee::findOrFail($id);
        //return Excel::download($reg->all(), 'employees.csv');
    }

    // Chức năng quản lý Role
    public function ShowDanhSachRole(Request $req){
        //$roles = Role::all();
        $roles = Role::orderBy('name', 'asc')->get();
        //dd($roles);
        return view('show-danh-sach-role', compact('roles'));
    }

    //Create role
    public function CreateViewRole(){
        return view('create-role');
    }
    public function CreateRole(Request $req){
        $req->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
        ], [
            'name.required' => 'Tên không được để trống',
            'name.regex' => 'Tên sai định dạng',
        ]);
        
        Role::create(['name'=>$req->name]);       

        return redirect(route('show.role'));
    }

    //Edit/Update role
    public function EditViewRole(Role $role){
        return view('edit-role', compact('role'));
    }

    public function EditRole(Request $req, Role $role){
        $req->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
        ], [
            'name.required' => 'Tên không được để trống',
            'name.regex' => 'Tên sai định dạng',
        ]);
        //Role::updated(['name'=>$req->name]);
        $role->name = $req->name;
        $role->update();
        //$role->save();
        return redirect(route('show.role'));
        //dd($role);
    }

    //Delete role
    public function DeleteRole(Role $role){
        $role->delete();
        session()->flash('success', 'Chúc mừng bạn đã xóa thành công');
        return redirect()->route('show.role');
    }


    //Chức năng quản lý permission
    public function ShowDanhSachPermission(Request $req){
        $permissions = Permission::orderBy('name', 'asc')->get();       
        //dd($permissions);
        return view('show-danh-sach-permission', compact('permissions'));
    }

    //Create permission
    public function CreateViewPermission(){
        return view('create-permission');
    }

    public function CreatePermission(Request $req){
        $req->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
        ], [
            'name.required' => 'Tên không được để trống',
            'name.regex' => 'Tên sai định dạng',
        ]);
        
        Permission::create(['name'=>$req->name]);       

        return redirect(route('show.permission'));
    }

    //Edit/Update permission
    public function EditViewPermission(Permission $permission){
        return view('edit-permission', compact('permission'));
    }

    public function EditPermission(Request $req, Permission $permission){
        $req->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
        ], [
            'name.required' => 'Tên không được để trống',
            'name.regex' => 'Tên sai định dạng',
        ]);
        //Role::updated(['name'=>$req->name]);
        $permission->name = $req->name;
        $permission->update();
        //$role->save();
        return redirect(route('show.permission'));
        //dd($role);
    }

    //Delete role
    public function DeletePermission(Permission $permission){
        $permission->delete();
        session()->flash('success', 'Chúc mừng bạn đã xóa thành công');
        return redirect()->route('show.permission');
    }


    //Nhóm quản lý User
    public function ShowDanhSachUser(Request $req){
        $users = User::all();
        return view('show-danh-sach-user', compact('users'));
    }

    //Create User
    public function CreateViewUser(){
        $roles = Role::all();
        return view('create-user', compact('roles'));
    }

    public function CreateUser(Request $req){
        $req->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|unique:users',
            'password' => 'required|min:6|max:10',
            'role' => 'required'
        ], [
            'name.required' => 'Họ và tên không được để trống',
            'name.regex' => 'Họ và tên sai định dạng',
            'email.required' => 'Email không được để trống',
            'email.regex' => 'Email sai định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Password không được để trống',
            'password.min' => 'Password không được ít hơn 6 kí tự',
            'password.max' => 'Password không được nhiều hơn 10 kí tự',
            'role.required' => 'Role không được để trống',
        ]);

        //dd($req -> role);
        
        $user = new User();
        $user -> name = $req -> name;
        $user -> email = $req -> email;
        $user -> password = Hash::make($req -> password);
        $user -> assignRole($req -> role);        
        $user -> save();
        session()->flash('success', 'Chúc mừng bạn đã tạo mới User thành công!');
        return redirect(route('show.user'));
    }

    //Edit/Update permission
    public function EditViewUser(User $user){
        $roles = Role::all();
        return view('edit-user', compact('user', 'roles'));
    }

    public function EditUser(Request $req, User $user){
        $req->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|min:6|max:255',
            'role' => 'required',
        ], [
            'name.required' => 'Họ và tên không được để trống',
            'name.regex' => 'Họ và tên sai định dạng',
            'email.required' => 'Email không được để trống',
            'email.regex' => 'Email sai định dạng',
            'password.required' => 'Password không được để trống',
            'password.min' => 'Password không được ít hơn 6 kí tự',
            'password.max' => 'Password không được nhiều hơn 255 kí tự',
            'role.required' => 'Role không được để trống',
        ]);
        $user -> name = $req -> name;
        $user -> email = $req -> email;
        $user -> password = Hash::make($req -> password);
        $user -> assignRole($req -> role);        
        $user -> update();
        return redirect()->route('show.user');
        //dd($role);
    }

    //Delete user
    public function DeleteUser(User $user) {
        $user->delete();
        session()->flash('success', 'Chúc mừng bạn đã xóa thành công');
        return redirect()->route('show.user');
    }
}
