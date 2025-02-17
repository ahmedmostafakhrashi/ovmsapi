<?php
$cookieFile = "cookiejar.txt";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['action'])) {
    if ($_GET['action'] == "login") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // تسجيل الدخول
        $loginUrl = "http://65.108.218.92:6868/api/cookie?username=$username&password=$password";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        $response = curl_exec($ch);
        curl_close($ch);

        echo json_encode(["response" => trim(str_replace("\r\n","",$response))]);
    }

    if ($_GET['action'] == "sendRequest") {
        $apiUrl = "http://65.108.218.92:6868/api/".$_POST['apiUrl'];
        $method = $_POST['method'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        $response = curl_exec($ch);
        curl_close($ch);

        echo json_encode(["success" => true, "response" => trim(str_replace("\r\n","",$response))]);
    }
}
?>
