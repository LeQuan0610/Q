<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hiệu thuốc</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <style>
        .details { display: none; }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://img.lovepik.com/photo/50096/1855.jpg_wh860.jpg" alt="Hình ảnh bất kỳ" width="200">
        <div class="header">
            <div class="button-container">
                <ul id="nav">
                    <li><a href="#">Tra cứu thuốc</a></li>
                    <li><a href="./scbenh.html">Tra cứu bệnh</a></li>
                    <li><a href="./nhap.html">Nhập hàng</a></li>
                    <li><a href="./xuat.html">Xuất hàng</a></li>
                    <li><a href="./lichsu.html">Lịch sử</a></li>
                </ul>
            </div>
        </div>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Tìm kiếm theo tên thuốc hoặc triệu chứng...">
            <button class="search-button">Tìm kiếm</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tên thuốc</th>
                    <th>Công dụng chỉ định</th>
                    <th>Số lượng</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "", "thuoc");
                if ($conn->connect_error) die("Kết nối tới cơ sở dữ liệu không thành công: " . $conn->connect_error);
                $sql = "SELECT * FROM thuoc";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row['ten_thuoc'] . "</td><td>" . $row['cong_dung'] . "</td><td>" . $row['so_luong'] . "</td><td><button class='details-button'>Chi tiết</button></td></tr>";
                    }
                } else {
                    echo "Không có dữ liệu.";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <div class="details">
            <table class="details-table">
                <thead>
                    <tr>
                        <th>Thuộc tính</th>
                        <th>Thông tin</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <script>
        const detailsButtons = document.querySelectorAll('.details-button');
        const detailsTable = document.querySelector('.details-table tbody');
        detailsButtons.forEach(button => {
            button.addEventListener('click', () => {
                detailsTable.innerHTML = '';
                const data = [
                    ['Tên thuốc', 'Thông tin tên thuốc'],
                    ['Thành phần', 'Thông tin thành phần'],
                    ['Công dụng chỉ định', 'Thông tin công dụng chỉ định'],
                    ['Chỉ định', 'Thông tin chỉ định'],
                    ['Dạng bào chế', 'Thông tin dạng bào chế'],
                    ['Hạn sử dụng', 'Thông tin hạn sử dụng'],
                    ['Quy cách đóng gói', 'Thông tin quy cách đóng gói']
                ];
                data.forEach(([attribute, info]) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td>${attribute}</td><td>${info}</td>`;
                    detailsTable.appendChild(row);
                });
                const details = document.querySelector('.details');
                details.style.display = 'block';
            });
        });
    </script>
</body>
</html>
