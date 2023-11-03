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
                    <li><a href="./scbenh.php">Tra cứu bệnh</a></li>
                    <li><a href="./nhap.php">Nhập hàng</a></li>
                    <li><a href="./xuat.php">Xuất hàng</a></li>
                    <li><a href="./lichsu.php">Lịch sử</a></li>
                </ul>
            </div>
        </div>
        <div class="search-box">
            <form method="post" action="">
                <input type="text" class="search-input" name="noidung" placeholder="Tìm kiếm theo tên thuốc hoặc triệu chứng...">
                <button type="submit" name="btn" class="search-button">Tìm kiếm</button>
            </form>
            <?php
            include "connect.php";
            
            if (isset($_POST["btn"])) {
                $noidung = $_POST['noidung'];
                $sql = "SELECT * FROM thuoc WHERE ten_thuoc LIKE '%$noidung%'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo $row['ten_thuoc'];
                }
            }
            ?>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Tên thuốc</th>
                    <th>Công dụng</th>
                    <th>Số lượng</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "", "thuoc");
                if ($conn->connect_error) die("Kết nối tới cơ sở dữ liệu không thành công: " . $conn->connect_error);
                
                // Số dòng trên mỗi trang
                $rowsPerPage = 10;
                
                // Trang hiện tại (mặc định là trang 1)
                $currentPage = 1;
                
                if (isset($_GET['page'])) {
                    $currentPage = $_GET['page'];
                }

                // Vị trí bắt đầu của dữ liệu trên trang hiện tại
                $startRow = ($currentPage - 1) * $rowsPerPage;

                $searchTerm = isset($_POST['noidung']) ? $_POST['noidung'] : '';

                if (isset($_POST["btn"])) {
                    $noidung = $_POST['noidung'];
                    $sql = "SELECT * FROM thuoc WHERE ten_thuoc LIKE '%$noidung%' LIMIT $startRow, $rowsPerPage";
                } else {
                    $sql = "SELECT * FROM thuoc LIMIT $startRow, $rowsPerPage";
                }

                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row['ten_thuoc'] . "</td><td>" . $row['cong_dung'] . "</td><td>" . $row['so_luong'] . "</td><td><button class='details-button' data-ten='" . $row['ten_thuoc'] . "' data-thanhphan='" . $row['thanh_phan'] . "' data-congdung='" . $row['cong_dung'] . "' data-chidinh='" . $row['chi_dinh'] . "' data-dangbche='" . $row['dang_bche'] . "' data-HSD='" . $row['HSD'] . "' data-QCDG='" . $row['QCDG'] . "' data-soluong='" . $row['so_luong'] . "'>Chi tiết</button></td></tr>";
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
        <div class="pagination">
            <?php
            // Tính số trang dựa trên số lượng dòng dữ liệu
            $conn = new mysqli("localhost", "root", "", "thuoc");
            $sql = "SELECT COUNT(*) AS total FROM thuoc WHERE ten_thuoc LIKE '%$searchTerm'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalRows = $row['total'];
            $totalPages = ceil($totalRows / $rowsPerPage);

            // Hiển thị các nút phân trang
            for ($i = 1; $i <= $totalPages; $i++) {
                // Bao gồm giá trị tìm kiếm trong liên kết phân trang
                echo "<a href='?page=$i'>$i</a> ";
            }
            ?>
        </div>
    </div>
    <script>
        const detailsButtons = document.querySelectorAll('.details-button');
        const detailsTable = document.querySelector('.details-table tbody');
        detailsButtons.forEach(button => {
            button.addEventListener('click', () => {
                detailsTable.innerHTML = '';
                const data = [
                    ['Tên thuốc', button.getAttribute('data-ten')],
                    ['Thành phần', button.getAttribute('data-thanhphan')],
                    ['Công dụng chỉ định', button.getAttribute('data-congdung')],
                    ['Chỉ định', button.getAttribute('data-chidinh')],
                    ['Dạng bào chế', button.getAttribute('data-dangbche')],
                    ['Hạn sử dụng', button.getAttribute('data-HSD')],
                    ['Quy cách đóng gói', button.getAttribute('data-QCDG')],
                    ['Số lượng', button.getAttribute('data-soluong')]
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
