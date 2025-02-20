<!doctype html>
<html lang="en">
<head>
    <title>Đăng Ký</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .small-text {
            display: none;
            font-size: 0.875rem;
            color: red;
        }
    </style>
    <!-- Thêm thư viện intl-tel-input -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Đăng Ký Tài Khoản</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên tài khoản</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <small id="nameWarning" class="small-text">Tên tài khoản phải dài hơn 8 ký tự.</small>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <small id="emailWarning" class="small-text">Email phải có đuôi @gmail.com.</small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật Khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required>
                        <small id="phoneWarning" class="small-text"></small>
                    </div>
                    
                    
                    
                    <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>Đăng Ký</button>
                </form>
                <p class="mt-3 text-center">
                    Đã có tài khoản? <a href="{{ route('login.form') }}">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    const phoneInput = document.getElementById("phone");
    const phoneWarning = document.getElementById("phoneWarning");

    // Khởi tạo intl-tel-input
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "vn", // Quốc gia mặc định (Việt Nam)
        separateDialCode: true, // Hiển thị mã vùng riêng biệt
        preferredCountries: ["vn", "us", "jp", "kr", "fr"], // Các quốc gia ưu tiên
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.min.js"
    });

    // Khi người dùng chọn quốc gia khác, cập nhật mã quốc gia
    phoneInput.addEventListener("countrychange", function () {
        const countryData = iti.getSelectedCountryData();
        console.log("Quốc gia được chọn: ", countryData);
    });

    // Kiểm tra số điện thoại hợp lệ
    phoneInput.addEventListener("input", function () {
        const isValid = iti.isValidNumber();
        if (!isValid) {
            phoneWarning.textContent = "Số điện thoại không hợp lệ!";
            phoneWarning.style.display = "block";
        } else {
            phoneWarning.style.display = "none";
        }
    });
});

        document.addEventListener("DOMContentLoaded", function () {
            const nameInput = document.getElementById("name");
            const nameWarning = document.getElementById("nameWarning");
            const emailInput = document.getElementById("email");
            const emailWarning = document.getElementById("emailWarning");
            const submitBtn = document.getElementById("submitBtn");

            function validateForm() {
                if (nameWarning.style.display === "none" && emailWarning.style.display === "none") {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }

            // Kiểm tra tên tài khoản
            nameInput.addEventListener("focus", function () {
                nameWarning.style.display = "block"; 
                nameWarning.textContent = "Tên tài khoản phải dài hơn 8 ký tự.";
            });

            nameInput.addEventListener("input", function () {
                const username = nameInput.value;
                const lengthValid = username.length > 8;
                const containsLetter = /[a-zA-Z]/.test(username);
                const containsNumber = /[0-9]/.test(username);
                const containsSpecialChar = /[^a-zA-Z0-9]/.test(username);

                if (!lengthValid) {
                    nameWarning.textContent = "Tên tài khoản phải dài hơn 8 ký tự.";
                    nameWarning.style.display = "block";
                } else if (!(containsLetter && containsNumber)) {
                    nameWarning.textContent = "Tên tài khoản phải chứa cả chữ và số.";
                    nameWarning.style.display = "block";
                } else if (containsSpecialChar) {
                    nameWarning.textContent = "Tên tài khoản không được chứa ký tự đặc biệt.";
                    nameWarning.style.display = "block";
                } else {
                    nameWarning.style.display = "none"; // Ẩn khi hợp lệ
                }
                validateForm();
            });

            // Kiểm tra email
            emailInput.addEventListener("focus", function () {
                emailWarning.style.display = "block"; 
                emailWarning.textContent = "địa chỉ email chưa hợp lệ";
            });

            emailInput.addEventListener("input", function () {
                const email = emailInput.value;
                if (!email.endsWith("@gmail.com")) {
                    emailWarning.textContent = "địa chỉ email chưa hợp lệ";
                    emailWarning.style.display = "block";
                } else {
                    emailWarning.style.display = "none"; // Ẩn khi hợp lệ
                }
                validateForm();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
