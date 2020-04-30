<?php
//数据库连接
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "dbproj";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start(); //开启session
$username_this = $_SESSION['username'];
$title_id=$_SESSION['title_id'];
if(isset($_POST["subGO"])){
    $content_pass = $_POST["password_in_content"];
    $sql_content_pass_this = "select  content, AES_DECRYPT(content,'$content_pass') from note 
                    where  username = '$username_this' and title = '$title_id'";
    $sql_content_pass = $conn->query($sql_content_pass_this);
    if ($sql_content_pass->num_rows>0){
        while($row = mysqli_fetch_array($sql_content_pass)){
            $content_by_e = $row["AES_DECRYPT(content,'$content_pass')"];
            echo "you secret note is here:";
            echo "<br/><br/><br/><br/>";
            echo $content_by_e;
            echo "<br/><br/><br/><br/>";
            echo "<a href='main.php'>Click return main page</a>";

            /* echo "<script type="."\""."text/javascript"."\"".">".
                 "window.location="."\""."create_note.html"."\""."</script>";*/
            exit;
        }
    }else{
        echo "fail to properly  decrypt thr encrypted text! ";
    }
}

?>