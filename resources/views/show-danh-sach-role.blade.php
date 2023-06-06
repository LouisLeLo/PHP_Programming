@extends('layouts.home')

@section('content')
    <h2 style="display: flex; justify-content: center">Quản lý Role</h2>

    <button style="margin-bottom: 10px" type="submit" class="btn btn-primary"><a href="{{ route('create.role') }}"
            style="color: white">Tạo mới role</a></button>

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
            @foreach ($roles as $role)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <th>{{ $role->name }}</th>
                    <th>
                        <button type="submit" class="btn btn-info"><a href="{{ route('edit.role', $role) }}"
                                style="color: white">Chỉnh
                                sửa</a></button>
                        <button type="submit" class="btn btn-danger"><a href="{{ route('delete.role', $role) }}"
                                onclick="return confirm('Bạn chắc chắn muốn xóa(yes/no) ?')"
                                style="color: white">Xóa</a></button>
                    </th>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
