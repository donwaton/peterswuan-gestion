<?php
require 'db.php';

$resp = array();

$username = $_POST["username"];
$password = $_POST["password"];

$resp['submitted_data'] = $_POST;

$login_status = 'invalid';

$sql = "SELECT * FROM usuario WHERE user_name='" . $username  . "' AND user_password = MD5('" . $password . "')";
$result = $conn->query($sql);

if($result->num_rows == 1){  
    $userinfo = $result->fetch_assoc();
    session_start();  
    $_SESSION['login'] = 1;
    $_SESSION['userid'] = $userinfo['user_id'];
    $_SESSION['perfil'] = $userinfo['tipousuario_id'];
    $login_status = 'success';
}

$resp['login_status'] = $login_status;

if ($login_status == 'success') {

    $resp['redirect_url'] = 'index.php';
}
echo json_encode($resp);
$conn->close();
?>