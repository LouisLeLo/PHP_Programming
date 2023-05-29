<h1>Hello</h1>

<form action="tinh-tong" method="POST"> @csrf
    {{-- @csrf cơ chế bảo mật, sinh ra 1 token(là 1 đoạn mã, chuỗi string) gửi xuống controller --}}
    Nhập vào a: <input type="text" name="a">
    Nhập vào b: <input type="text" name="b">
    <button type="submit" >Xac nhan</button>
</form>
