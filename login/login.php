<?php
header("Content-type:text/html;charset=utf-8");
$servername ="localhost";
$username = "root";
$password = "123456789";
$database = "dbproj";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($conn) {
    if (isset($_POST["sub"])) {
        $name = $_POST["username"];
        $password1 = $_POST["password"];
        //判断是否为空
        if ($name == "" || $password1 == ""){
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" .
                "window.alert" . "(" . "\"" . "username or password should not be blank!！" . "\"" . ")"
                . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "login.html" . "\"" . "</script>";
        }else{
           /* $str = "select * from user where username='$name' and password='$password1'";
            $result = $conn->query($str);*/
            $stmt = $conn->prepare("select * from user where username=? and password=?");
            $stmt->bind_param('ss',$name,$password1);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0)//判断密码与注册时密码是否一致
            {
                session_start();
                $_SESSION["username"]="$name";
                //echo $name;
                //header("Location:../note/main.php");
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "../note/main.php" . "\"" . "</script>";
            }else {
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "usrname or password not correct！" . "\"" . ")" . ";" . "</script>";
                echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "login.html" . "\"" . "</script>";
            }
        }

    }
}
?>