<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hiệu thuốc</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <style>
    </style>
</head>
<body>
    <div class="container">
        <!-- Hàng 1: Chứa ảnh -->
        <img src="https://img.lovepik.com/photo/50096/1855.jpg_wh860.jpg" alt="Hình ảnh bất kỳ" width="200">
        
        <!-- Hàng 2: Chứa các nút bấm -->
        <div class="header">
            <div class="button-container">
                <ul id="nav">
                    <li><a href="./scthuoc.php">Tra cứu thuốc</a></li>
                    <li><a href="./scbenh.php">Tra cứu bệnh</a></li>
                    <li><a href="./nhap.php">Nhập hàng</a></li>
                    <li><a href="./xuat.php">Xuất hàng</a></li>
                    <li><a href="#">Lịch sử</a></li>
                </ul>
                <!-- <a href="tra-cuu-thuoc.html" class="button">Tra cứu thuốc</a>
                <a href="tra-cuu-benh.html" class="button">Tra cứu bệnh</a>
                <a href="nhap-hang.html" class="button">Nhập hàng</a>
                <a href="xuat-hang.html" class="button">Xuất hàng</a> -->
            </div>
        </div>
        <!-- Hàng 3: Chứa ô tìm kiếm -->
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Tìm kiếm theo tên thuốc hoặc triệu chứng...">
            <button class="search-button">Tìm kiếm</button>
        </div>

        <!-- Hàng 4: Chứa bảng dữ liệu -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Tình trạng</th>
                    <th>Người thực hiện</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>10/5/2023</td>
                    <td>xuất</td>
                    <td>nguyễn văn A</td>
                    <td>chi tiết</td>
                </tr>
                <tr>
                    <td>10/5/2023</td>
                    <td>Nhập</td>
                    <td>nguyễn văn C</td>
                    <td>chi tiết</td>
                </tr>
                <!-- Thêm các dòng dữ liệu khác tại đây -->
            </tbody>
        </table>
    </div>
</body>
</html>
