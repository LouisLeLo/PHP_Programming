@extends('layouts.home')

@section('content')
    <h2 style="display: flex; justify-content: center">DANH SÁCH NHÂN VIÊN</h2>

    <div style="margin-left: 340px">
        <a href="{{ route('create.employee') }}">Tạo mới nhân viên</a>
        <p></p>
    </div>

    <div id="timkiem" style="margin-left: 340px ">
        <form action="{{ route('search.employee') }}" method="get">
            @csrf
            <input type="text" placeholder="Từ khóa" name="tukhoa" value="{{ request()->tukhoa }}">
            <button type="submit">Tìm kiếm</button>
        </form>
        <div style="margin-top:20px;">
            <form action="">
                <select name="rows" id="">
                    <option value="10" @php echo request()->rows == 10 ? 'selected' : ''; @endphp>10</option>
                    <option value="20" @php echo request()->rows == 20 ? 'selected' :  ''; @endphp>20</option>
                    <option value="50" @php echo request()->rows == 50 ? 'selected' : ''; @endphp>50</option>
                    <option value="100" @php echo request()->rows == 100 ? 'selected' :  ''; @endphp>100</option>
                </select>
                <button type="submit">Áp dụng</button>
            </form>
            <p>Tổng số nhân viên: {{ $employees->total() }}</p>
            <p>Trang {{ $employees->currentPage() . '/' . $employees->count() }}</p>
        </div>
    </div>

    <form action="{{route('employee.export')}}" method="post" id="exportForm">
        @csrf
        <input type="text" name="ids" style="margin-left: 340px" id="hiddenvalues">
        <input type="button" value="Xuất" onclick="export_function()">
    </form>

    <br>

    <table border="1" style="width: 50%; height: 80%; margin: 0 auto;">
        <thead>
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Họ và tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Điểm trung bình</th>
                <th>Địa chỉ</th>
                <th>Tên phòng ban</th>
                <th>Hành động</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <th>{{ $employee->id }}</th>
                    <th>
                        @if (!empty($employee->avatar))
                            <img width="90" height="90" style="border-radius: 30%"
                                src="{{ asset($employee->avatar->url) }}" alt="">
                        @endif
                    </th>
                    <th>{{ $employee->hoten }}</th>
                    <th>{{ $employee->gioitinh }}</th>
                    <th>{{ $employee->ngaysinh }}</th>
                    <th>{{ $employee->dtb }}</th>
                    <th>{{ $employee->diachi }}</th>
                    {{-- bởi vì có nhiều đối tượng employee ko có tên phòng ban nên bị null, nên ta thêm "??" biểu thức chính quy hiển thị --}}
                    {{-- <th>{{ $employee->department != null ? $employee->department->ten : '' }}</th> --}}
                    <th>{{ $employee->department->ten ?? '' }}</th>
                    <th>
                        <a href="{{ route('edit.employee', $employee->id) }}"
                            style="background-color: rgb(81, 238, 92)">Chỉnh
                            sửa</a>
                        <a href="{{ route('delete.employee', $employee->id) }}"
                            onclick="return alert('Bạn chắc chắn muốn xóa(yes/no) ?')"
                            style="background-color: rgb(215, 120, 103)">Xóa</a>
                    </th>
                    <th>
                        <input type="checkbox" name="name_cua_checkbox" data-id="{{ $employee->id }}">
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p> </p>

    <div id="paginate">
        <div style="display: flex; justify-content: center">{{ $employees->links() }}</div>

    </div>

    <p> </p>

    <table border="1" style="width: 50%; height: 80%; margin: 0 auto;">
        <thead>
            <tr>
                <th>Id</th>
                <th>Tên phòng ban</th>
                <th>Tên trưởng phòng</th>
                <th>Tên nhân viên</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->id }}</td>
                    <td>{{ $department->ten }}</td>
                    <td>{{ $department->truongPhong->hoten ?? '' }}</td>
                    <td>
                        @foreach ($department->employees as $employee)
                            {{ $employee->hoten }},
                        @endforeach
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('scripts')
    <script>
        function export_function() {
            var hiddenInput = $("#hiddenvalues");
            var checked_ids = [];
            $("input[name='name_cua_checkbox']:checked").each(function() {
                    checked_ids.push($(this).data('id'));
            });
            hiddenInput.val(checked_ids);
            $("#exportForm").submit();
        }
    </script>
@endsection
