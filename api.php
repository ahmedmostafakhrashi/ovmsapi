<?php
$cookieFile = __DIR__ . "/cookiejar.txt"; // استخدم المسار المطلق لضمان الوصول إلى الملف

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['action'])) {
    if ($_GET['action'] == "login") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // رابط تسجيل الدخول
        $loginUrl = "http://65.108.218.92:6868/api/cookie?username=$username&password=$password";
        
        // إعداد cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // تأكد من استخدام نفس ملف الكوكيز
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // في حالة وجود إعادة توجيه
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // ضبط مهلة الاتصال
        
        // تنفيذ الطلب
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo json_encode(["error" => curl_error($ch)]);
            curl_close($ch);
            exit;
        }

        curl_close($ch);

        // تنظيف النص المستلم وإرساله كـ JSON
        echo json_encode(["success" => true, "response" => trim(str_replace("\r\n", "", $response))]);
    }

    if ($_GET['action'] == "sendRequest") {
        if (!isset($_POST['apiUrl']) || empty($_POST['apiUrl'])) {
            echo json_encode(["error" => "API URL is required"]);
            exit;
        }

        $apiUrl = "http://65.108.218.92:6868/api/" . ltrim($_POST['apiUrl'], "/");
        $method = $_POST['method'] ?? "GET";

        // إعداد cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        // تنفيذ الطلب
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo json_encode(["error" => curl_error($ch)]);
            curl_close($ch);
            exit;
        }

        curl_close($ch);

        // تنظيف وإرجاع الاستجابة
        echo json_encode(["success" => true, "response" => trim(str_replace("\r\n", "", $response))]);
    }
}
?>
