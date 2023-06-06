@extends('layouts.home')

@section('content')
    <div class="card" style="max-width: 800px; margin: 0 auto; margin-top: 80px;">
        <div class="card-header" style="font-weight: bold">
            TẠO MỚI PERMISSION
        </div>
        <div class="card-body">
            <form action="{{ route('create.permission.post') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Tên permission:</label>
                    <input type="text" class="form-control" name="name">
                    @error('name')
                        <p style="color:red; margin-top:10px; margin-bottom:10px">{{ $errors->first('name') }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection
