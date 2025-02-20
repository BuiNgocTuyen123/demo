<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Danh sách sản phẩm</title>
</head>
<body>
    <h1>Danh sách sản phẩm 2</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Số l</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ number_format($product->price, 2) }} VNĐ</td> {{-- Hiển thị giá có dấu phân cách --}}
            <td>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" width="50" alt="Hình sản phẩm">
                @else
                    Không có ảnh
                @endif
            </td>
            <td>{{ $product->quantity }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
