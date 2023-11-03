<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hiệu thuốc</title>
    <link rel="stylesheet" href="./assets/css/main.css">
    <style>
        /* CSS cho khung đăng nhập */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        /* Định dạng trường nhập và nút trong khung đăng nhập */
        .popup-content input[type="text"],
        .popup-content input[type="number"],
        .popup-content input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .popup-content button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .popup-content button:last-child {
            background-color: #ccc;
        }
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
                    <li><a href="#">Xuất hàng</a></li>
                    <li><a href="./lichsu.php">Lịch sử</a></li>
                </ul>
            </div>
        </div>
        <!-- Hàng 3: Chứa ô tìm kiếm -->
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
                        echo "<tr><td>" . $row['ten_thuoc'] . "</td><td>" . $row['cong_dung'] . "</td><td>" . $row['so_luong'] . "</td><td><button class='details-button' data-ten='" . $row['ten_thuoc'] . "' data-thanhphan='" . $row['thanh_phan'] . "' data-congdung='" . $row['cong_dung'] . "' data-chidinh='" . $row['chi_dinh'] . "' data-dangbche='" . $row['dang_bche'] . "' data-HSD='" . $row['HSD'] . "' data-QCDG='" . $row['QCDG'] . "' data-soluong='" . $row['so_luong'] . "'>Chi tiết</button></td><td><button class='xuathang-button' data-ten='" . $row['ten_thuoc'] . "' data-soluong='" . $row['so_luong'] . "'>Xuất hàng</button></td></tr>";
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
        <div class="xuathang-details">
            <table class="xuathang-details-table">
                <thead>
                    <tr>
                        <th>Tên thuốc</th>
                        <th>Số lượng</th>
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
    <div id="xuathang-popup" class="popup">
        <div class="popup-content">
            <h2>Nhập thông tin hàng xuất</h2>
            <form>
                <input type="text" id="xuathang-ten" placeholder="Tên sản phẩm" disabled>
                <input type="number" id="xuathang-soluong" placeholder="Số lượng">
                <button type="submit" onclick="xuatHang()">Xác nhận</button>
                <button type="button" onclick="closeXuatHangPopup()">Hủy</button>
            </form>
        </div>
    </div>
    <script>
        const detailsButtons = document.querySelectorAll('.details-button');
        const detailsTable = document.querySelector('.details-table tbody');
        const xuathangButtons = document.querySelectorAll('.xuathang-button');
        const xuathangTable = document.querySelector('.xuathang-details-table tbody');
        
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

        xuathangButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tenThuoc = button.getAttribute('data-ten');
                const soLuong = button.getAttribute('data-soluong');
                document.getElementById('xuathang-ten').value = tenThuoc;
                document.getElementById('xuathang-ten').setAttribute('data-max', soLuong);
                xuathangTable.innerHTML = '';
                const row = document.createElement('tr');
                row.innerHTML = `<td>${tenThuoc}</td><td>${soLuong}</td>`;
                xuathangTable.appendChild(row);
                const xuathangPopup = document.getElementById("xuathang-popup");
                xuathangPopup.style.display = "block";
            });
        });

        function closeXuatHangPopup() {
            const xuathangPopup = document.getElementById("xuathang-popup");
            xuathangPopup.style.display = "none";
        }

        function xuatHang() {
            const tenThuoc = document.getElementById('xuathang-ten').value;
            const soLuong = parseInt(document.getElementById('xuathang-soluong').value);
            const maxSoLuong = parseInt(document.getElementById('xuathang-ten').getAttribute('data-max'));
            if (soLuong > 0 && soLuong <= maxSoLuong) {
                // Thực hiện xử lý xuất hàng tại đây, ví dụ thông báo xuất hàng thành công
                alert(`Đã xuất ${soLuong} đơn vị của thuốc ${tenThuoc}.`);
                closeXuatHangPopup();
            } else {
                alert('Số lượng không hợp lệ. Vui lòng kiểm tra lại.');
            }
        }
    </script>
</body>
</html>
