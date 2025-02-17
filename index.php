<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تجربة API لـ OVMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">تجربة API لـ OVMS</h2>

    <!-- قسم تسجيل الدخول -->
    <div class="card p-4 shadow" id="loginSection">
        <div class="mb-3">
            <label for="username" class="form-label">اسم المستخدم:</label>
            <input type="text" id="username" class="form-control" value="test">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور:</label>
            <input type="password" id="password" class="form-control" value="12345678">
        </div>
        <button class="btn btn-primary w-100" onclick="login()">تسجيل الدخول</button>
    </div>

    <!-- قسم استدعاء API بعد تسجيل الدخول -->
    <div class="card p-4 shadow mt-4" id="apiSection" style="display: none;">
        <h4>إرسال طلب API</h4>
        <div class="mb-3">
            <label for="apiUrl" class="form-label">رابط الـ API:</label>
            <br />
            <div class=" row d-flex">
            <label class="form-label col-md-3" for="">http://65.108.218.92:6868/api/</label>
                <div class="col-md-8">
                <input type="text" id="apiUrl" class="form-control  mx-2" value="vehicles" placeholder="أدخل رابط API">
                </div>
            </div> 
            <label for="apiUrl" class="form-label">EX:vehicles - token</label>
        </div>
        <div class="mb-3">
            <label for="requestMethod" class="form-label">نوع الطلب:</label>
            <select id="requestMethod" class="form-select">
                <option value="GET">GET</option>
                <option value="POST">POST</option>
                <option value="PUT">PUT</option>
                <option value="DELETE">DELETE</option>
            </select>
        </div>
        <button class="btn btn-success w-100" onclick="sendRequest()">إرسال الطلب</button>
    </div>

    <!-- عرض النتائج -->
    <div class="mt-4" id="responseContainer" style="display: none;">
        <h4>نتيجة الطلب:</h4>
        <pre id="responseData" class="p-3 bg-white border rounded shadow-sm"></pre>
    </div>
</div>

<script>
function login() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    fetch("api.php?action=login", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `username=${username}&password=${password}`
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("responseContainer").style.display = "block";
        document.getElementById("responseData").innerText = JSON.stringify(data, null, 4);

        // إذا تم تسجيل الدخول بنجاح، إظهار قسم إرسال الطلبات
        if (data.response == "Login ok") {
            document.getElementById("loginSection").style.display = "none";
            document.getElementById("apiSection").style.display = "block";
        }
    })
    .catch(error => console.error("Error:", error));
}

function sendRequest() {
    let apiUrl = document.getElementById("apiUrl").value;
    let method = document.getElementById("requestMethod").value;

    fetch("api.php?action=sendRequest", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `apiUrl=${encodeURIComponent(apiUrl)}&method=${method}`
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("responseContainer").style.display = "block";
        document.getElementById("responseData").innerText = JSON.stringify(data, null, 4);
    })
    .catch(error => console.error("Error:", error));
}
</script>

</body>
</html>
