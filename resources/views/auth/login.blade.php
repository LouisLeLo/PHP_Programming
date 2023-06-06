@extends('layouts.home')
@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto; margin-top: 80px;">
        <div class="card-header">
            ĐĂNG NHẬP
        </div>
        <div class="card-body">
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">Email</label>
                    <input class="form-control" type="text" name="email" placeholder="Nhập email của bạn"
                        value="{{ old('email') }}">
                </div>
                <p style="color: red">{{ session()->get('message') }}</p>
                @error('email')
                    <p style="color:red; margin-top:10px; margin-bottom:10px">{{ $errors->first('email') }}</p>
                @enderror
                <div class="form-group">
                    <label for="">Password</label>
                    <input class="form-control" type="password" name="password" placeholder="*******" value="">
                </div>
                @error('password')
                    <p style="color:red; margin-top:10px; margin-bottom:10px">{{ $errors->first('password') }}</p>
                @enderror
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">ĐĂNG NHẬP</button>
                </div>
            </form>
        </div>
    </div>
@endsection
