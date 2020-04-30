<?php
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
if($conn){
    session_start(); //开启session
    $username_this = $_SESSION['username'];
    if(isset($_POST["submit"])){
        $title = $_POST["title"];
        $content = $_POST["content"];
        //$private = $_POST["private"];
        //$not_private = $_POST["not_private"];
        $note_pass = $_POST["note_pass"];

        //确定加密还是不加密,不为空加密,如果加密，$private_note为1，不加密为0
        if(empty($note_pass)){
            $private_note = 0;
        }else{
            $private_note = 1;
        }
        if($title==""||$content==""){
            echo"<script type="."\""."text/javascript"."\"".">"
                ."window.alert"."("."\""."NOT BLANK IN TITLE OR CONTENT！"."\"".")".";"."</script>";
            echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."create_note.html"."\""."</script>";
            exit;
        }
       /* if($private_note==""){
            echo"<script type="."\""."text/javascript"."\"".">"
                ."window.alert"."("."\""."SELECT YOUR  PRIVATE OR NOT！"."\"".")".";"."</script>";
            echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."create_note.html"."\""."</script>";
            exit;
        }*/
        /*if($private_note=="0"){
            if($note_pass==""){
                echo"<script type="."\""."text/javascript"."\"".">"
                    ."window.alert"."("."\""."WRITE YOUR PRIVATE PASSWORD FOR NOTE！"."\"".")".";"."</script>";
                echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."create_note.html"."\""."</script>";
                exit;
            }

        }*/
        //username should be unique
        $sql_unique_title = "select title from note where title = 
                                '$title' and username = '$username_this'";
        $result_title = $conn->query($sql_unique_title);

        if ($result_title->num_rows>0){

            echo"<script type="."\""."text/javascript"."\"".">"
                ."window.alert"."("."\""."you have the same title!"."\"".")".";"."</script>";
            echo"<script type="."\""."text/javascript"."\"".">".
                "window.location="."\""."create_note.html"."\""."</script>";
            exit;
        }else{
            if($private_note == 0){
                $sql_create_note_notprivate="insert into note (username,title,content,private_note) VALUES 
                            ('$username_this','$title','$content','$private_note')";
                if ($conn->query($sql_create_note_notprivate) === TRUE) {
                    //写入成功
                    echo"<script type="."\""."text/javascript"."\"".">"
                        ."window.alert"."("."\""."write note success！"."\"".")".";"."</script>";
                    echo"<script type="."\""."text/javascript"."\"".">".
                        "window.location="."\""."main.php"."\""."</script>";
                    exit;
                } else {
                    echo "Error: " . $sql_create_note_notprivate . "<br>" . $conn->error;
                }
            }
            if($private_note == 1){
                $sql_create_note_private="insert into note (username,title,content,private_note) VALUES 
                            ('$username_this','$title',AES_ENCRYPT('$content','$note_pass'),'$private_note')";
                if ($conn->query($sql_create_note_private) === TRUE) {
                    //写入成功
                    echo"<script type="."\""."text/javascript"."\"".">"
                        ."window.alert"."("."\""."write note success！"."\"".")".";"."</script>";
                    echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."main.php"."\""."</script>";
                    exit;
                } else {
                    echo "Error: " . $sql_create_note_private . "<br>" . $conn->error;
                }
            }

        }

    }
}
$conn->close();
?>