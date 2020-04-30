<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<p>Find your secret content, here!</p>


<!--<script>
    function get_content() {
        var password = prompt("make a password for your note");
        if (password != null){
            document.getElementById("pass1").value = password;
        }else{
            alert("you click [cancel]");
        }
    }
</script>
<input type="radio" name="private"  onclick="get_content()" /><br>
<input type="hidden" id="pass1" name="note_pass">
-->
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
$title_id = $_GET['id'];
if(!isset($_POST["subGO"])){if(isset($title_id)){
    $sql_tr_title = "select title, private_note,content from note where  username = '$username_this' and title = '$title_id' " ;
    $by_tr_title = $conn->query($sql_tr_title);
    while($row = mysqli_fetch_array($by_tr_title)){
        if($row['private_note']==0){

            //echo $row['content'];
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . $row['content']  . "\"" . ")" . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "main.php" . "\"" . "</script>";
            exit;
            /*echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . $row['content']  . "\"" . ")" . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "main.php" . "\"" . "</script>";
            exit;*/
        }else{
            $_SESSION['title_id']=$title_id;
/*            echo "<a href='view.php?id2=$title_id'></a>";*/
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "econtent.html" . "\"" . "</script>";
        }
    }

}}else{
    $content_pass = $_POST["password_in_content"];
    $sql_content_pass_this = "select  content,AES_DECRYPT(content,'$content_pass') from note 
                    where  username = '$username_this' and title = '$title_id'";
    $sql_content_pass = $conn->query($sql_content_pass_this);
    if ($sql_content_pass->num_rows>0){
        while($row = mysqli_fetch_array($sql_content_pass)){
            $content_by_e = $row['content'];
            echo $content_by_e;
            /* echo "<script type="."\""."text/javascript"."\"".">".
                 "window.location="."\""."create_note.html"."\""."</script>";*/
            exit;
        }
    }else{
        echo "fail to properly  decrypt thr encrypted text! ";
    }
}
?>
</body>
</html>