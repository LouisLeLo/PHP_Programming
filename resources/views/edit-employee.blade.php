@extends('layouts.home')

@section('content')
    <h1>Chỉnh sửa NHÂN VIÊN</h1>
    <form action="{{ route('edit.employee.post', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        Avatar: <input type="file" name="avatar"><br>
        @error('avatar')
            <p class="error">// {{ $errors->first('avatar') }}</p>
        @enderror
        <br>
        Avatar hiện tại:
        @if (!empty($employee->avatar))
            <img width="90" height="90" src="{{ asset($employee->avatar->url) }}" alt="">
        @endif
        <br>
        Họ và tên: <input type="text" name="hoten" value="{{ $employee->hoten }}">
        @error('hoten')
            <p class="error">// {{ $errors->first('hoten') }}</p>
        @enderror
        <br>
        Giới tính: <input type="text" name="gioitinh" value="{{ $employee->gioitinh }}">
        @error('gioitinh')
            <p class="error">// {{ $errors->first('gioitinh') }}</p>
        @enderror
        <br>
        Ngày sinh: <input type="text" name="ngaysinh" value="{{ $employee->ngaysinh }}">
        @error('ngaysinh')
            <p class="error">// {{ $errors->first('ngaysinh') }}</p>
        @enderror
        <br>
        Điểm trung bình: <input type="text" name="dtb" value="{{ $employee->dtb }}">
        @error('dtb')
            <p class="error">// {{ $errors->first('dtb') }}</p>
        @enderror
        <br>
        Địa chỉ: <input type="text" name="diachi" value="{{ $employee->diachi }}">
        <br>
        <div>
            <button style="margin-right: 150px">
                <a href="{{ route('show.employee') }}">Hủy bỏ</a>
            </button>
            <button type="submit">Hoàn tất</button>
        </div>
    </form>
@endsection
