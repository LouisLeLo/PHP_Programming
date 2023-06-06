@extends('layouts.home')
@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto; margin-top: 80px">
        <div class="card-header">
            ĐĂNG KÝ
        </div>
        <div class="card-body">
            <form action="{{ route('register.submit') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Tên đăng nhập:</label>
                    <input type="text" class="form-control" name="name" placeholder="Nhập tên đăng nhập"
                        value="{{ old('name') }}">
                    @error('name')
                        <p style="color: red" class="error">{{ $errors->first('name') }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Email:</label>
                    <input type="text" class="form-control" name="email" placeholder="Nhập email"
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="error" style="color: red">{{ $errors->first('email') }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="********">
                    @error('password')
                        <p class="error" style="color: red">{{ $errors->first('password') }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Confirm password:</label>
                    <input type="password" class="form-control" placeholder="********" name="password_confirmation">
                    @error('password')
                        <p class="error" style="color: red">{{ $errors->first('password') }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">ĐĂNG KÝ</button>
                </div>
            </form>
        </div>
    </div>
@endsection
