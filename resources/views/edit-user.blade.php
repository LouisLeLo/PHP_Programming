@extends('layouts.home')

@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto; margin-top: 80px;">
        <div class="card-header" style="font-weight: bold">
            CHỈNH SỬA USER
        </div>
        <div class="card-body">
            <form action="{{ route('edit.user.post', $user) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Tên user</label>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                    @error('name')
                        <p style="color:red; margin-top:10px; margin-bottom:10px">{{ $errors->first('name') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                    @error('email')
                        <p style="color:red; margin-top:10px; margin-bottom:10px">{{ $errors->first('email') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" value="{{ $user->name }}">
                    @error('password')
                        <p style="color:red; margin-top:10px; margin-bottom:10px">{{ $errors->first('password') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Role</label>
                    <select class="form-control" name="role">
                        <option value="">Default select</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p style="color:red; margin-top:10px; margin-bottom:10px">{{ $errors->first('role') }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection
