<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\File as File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function ShowDanhSachEmployee(Request $request){
        //$employees = Employee::all() gọi tới static function query tất cả trong db
        $tukhoa = $request->tukhoa;
        $employees = Employee::where('gioitinh', 'like', '%'.$tukhoa.'%')->orWhere('ngaysinh', 'like', '%'.$tukhoa.'%')->orWhere('diachi', 'like', '%'.$tukhoa.'%')->orWhere('hoten', 'like', '%'.$tukhoa.'%');
        $employees = $employees->orderBy('dtb','desc');

        $request->rows != null ? $employees = $employees->paginate($request->rows) : $employees = $employees->paginate(10);
        
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
        dd($reg->all());
    }
}
