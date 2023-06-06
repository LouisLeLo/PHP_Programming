@extends('layouts.home')

@section('content')
    <h1>TẠO MỚI NHÂN VIÊN</h1>
    <style>
        .error {
            color: rgb(207, 74, 51);
            display: inline;
        }
    </style>

    <form action="{{ route('create.employee.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        Avatar: <input type="file" name="avatar"><br>
        @error('hoten')
            <p class="error">// {{ $errors->first('avatar') }}</p>
        @enderror
        <br>
        Họ và tên: <input type="text" name="hoten">
        @error('hoten')
            <p class="error">// {{ $errors->first('hoten') }}</p>
        @enderror
        <br>
        Giới tính: <input type="text" name="gioitinh">
        @error('gioitinh')
            <p class="error">// {{ $errors->first('gioitinh') }}</p>
        @enderror
        <br>
        Ngày sinh: <input type="text" name="ngaysinh">
        @error('ngaysinh')
            <p class="error">// {{ $errors->first('ngaysinh') }}</p>
        @enderror
        <br>
        Điểm trung bình: <input type="text" name="dtb">
        @error('dtb')
            <p class="error">// {{ $errors->first('dtb') }}</p>
        @enderror
        <br>
        Địa chỉ: <input type="text" name="diachi">
        <br>
        Tên phòng ban: <select name="department_id">
            @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->ten }}</option>
            @endforeach
        </select>
        <br>
        <div>
            <button style="margin-right: 150px">
                <a href="{{ route('show.employee') }}">Quay về</a>
            </button>
            <button type="submit">Tạo mới</button>
        </div>

    </form>
@endsection
