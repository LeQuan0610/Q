document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("login-form");

    loginForm.addEventListener("submit", function(e) {
        e.preventDefault(); // Ngăn form gửi dữ liệu

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Kiểm tra thông tin đăng nhập (thay bằng logic kiểm tra thực tế)
        if (username === "admin" && password === "password") {
            // Đăng nhập thành công, chuyển hướng đến trang A.html
            window.location.href = "A.html";
        } else {
            alert("Đăng nhập không thành công. Vui lòng kiểm tra tên người dùng và mật khẩu.");
        }
    });
});
