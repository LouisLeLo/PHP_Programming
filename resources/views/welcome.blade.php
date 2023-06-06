@extends('layouts.home')
@section('content')
    <div>
        @role('admin')
            I am a admin!
        @else
            I am not a admin!
        @endrole
    </div>
@endsection
