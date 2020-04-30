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
    if(isset($_POST["submit"])){
        $name = $_POST["username"];
        $password = $_POST["password"];
        if($name==""||$password==""){
            echo"<script type="."\""."text/javascript"."\"".">"
                ."window.alert"."("."\""."NOT BLANK IN USERNAME OR PASSWORD！"."\"".")".";"."</script>";
            echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."create_user.html"."\""."</script>";
            exit;
        }
        //username should be unique
        $stmt = $conn->prepare("select username from user where username = ?");
        $stmt->bind_param('s',$name);
        $stmt->execute();
        $result = $stmt->get_result();
        /*$sqlun = "select username from user where username = '$name'";
        $result = $conn->query($sqlun);*/
        if ($result->num_rows>0){

            echo"<script type="."\""."text/javascript"."\"".">"
                ."window.alert"."("."\""."username is unique!"."\"".")".";"."</script>";
            echo"<script type="."\""."text/javascript"."\"".">".
                "window.location="."\""."create_user.html"."\""."</script>";
            exit;
        }else{

            $sql="insert into user (username,password) VALUES ('$name','$password')";
            if ($conn->query($sql) === TRUE) {
                //echo "New record created successfully";
                echo"<script type="."\""."text/javascript"."\"".">"."window.location="."\""."register_success.html"."\""."</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

    }
}
$conn->close();
?>