@extends('layouts.home')

@section('content')
    <h2 style="display: flex; justify-content: center">Quản lý User</h2>

    <button style="margin-bottom: 10px" type="submit" class="btn btn-primary"><a href="{{ route('create.user') }}"
            style="color: white">Tạo mới
            user</a></button>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên user</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <th scope="row">{{ $user->name }}</th>
                    <th scope="row">{{ $user->email }}</th>
                    <th scope="row">
                        @foreach ($user->getRoleNames() as $item)
                            <span class="badge badge-secondary mr-2">{{ $item }}</span>
                        @endforeach
                    </th>
                    <th>
                        <button type="submit" class="btn btn-info"><a href="{{ route('edit.user', $user) }}"
                                style="color: white">Chỉnh
                                sửa</a></button>
                        <button type="submit" class="btn btn-success"><a href="" style="color: white">Cấp
                                quyền</a></button>
                        <button type="submit" class="btn btn-danger"><a href="{{ route('delete.user', $user) }}"
                                onclick="return confirm('Bạn chắc chắn muốn xóa(yes/no) ?')"
                                style="color: white">Xóa</a></button>
                    </th>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
