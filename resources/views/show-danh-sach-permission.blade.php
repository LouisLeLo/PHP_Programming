@extends('layouts.home')

@section('content')
    <h2 style="display: flex; justify-content: center">Quản lý Permission</h2>

    <button style="margin-bottom: 10px" type="submit" class="btn btn-primary"><a href="{{ route('create.permission') }}"
            style="color: white">Tạo mới
            permission</a></button>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên role</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($permissions as $permission)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <th>{{ $permission->name }}</th>
                    <th>
                        <button type="submit" class="btn btn-info"><a href="{{ route('edit.permission', $permission) }}"
                                style="color: white">Chỉnh
                                sửa</a></button>
                        <button type="submit" class="btn btn-danger"><a
                                href="{{ route('delete.permission', $permission) }}"
                                onclick="return confirm('Bạn chắc chắn muốn xóa(yes/no) ?')"
                                style="color: white">Xóa</a></button>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
