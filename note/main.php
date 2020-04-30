<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>m</title>
</head>
<body>
<form method="post" action="main.php">
    <input type="text" name="search_content" placeholder="search content here" style="height:21px;width:449px"><br/><br/>
    <input type="password" name="search_content_pass" style="height:21px;width:449px" placeholder="if your content is encryption，pass here!"><br/><br/>
    <input type="submit" value="search" ><br/><br/><br/>
</form>
<a  href=create_note.html title="to create_note">If you want to make a new note, click here!</a><br/><br/><br/><br/>

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
echo "YOUR USERNAME is $username_this";
echo "<br>";
echo "<br>";
echo "title".
    "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
    "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
    "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
    "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
    "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
    "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
    "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
    "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
    "parvate or not";
echo "<br>";
echo "<br>";

$sql_title_by_create_time = "select title,private_note from note where  username = '$username_this' ORDER BY create_time desc" ;
$by_time_title = $conn->query($sql_title_by_create_time);
while($row = mysqli_fetch_array($by_time_title))
    {   if($row['private_note']==0){
    $privated = "not private message";
    }else{
    $privated = "private message";
}
    $this_title = $row['title'];
        echo "<a href='view.php?id=$this_title'>$this_title</a>".
        "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
        "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
        "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
        "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
        "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
        "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
        "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp".
        "&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp". $privated;
    echo "<br>";
}
//搜索框内容,加密搜索
if(isset($_POST['search_content'])) {
    $pass_blank_or_not = $_POST['search_content_pass'];
    if (!$pass_blank_or_not == '') {
        $this_content_this = $_POST['search_content'];
        $this_content_pass = $_POST['search_content_pass'];
        $sql_search_title_by_content_pass = "select title, content,AES_DECRYPT(content,'$this_content_pass') from note 
                    where  username = '$username_this' and AES_DECRYPT(content,'$this_content_pass') LIKE '%{$this_content_this}%'";
        $sql_content_pass = $conn->query($sql_search_title_by_content_pass);
        if ($sql_content_pass->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($sql_content_pass)) {
                $search_title = $row['title'];
                echo '<br/>' . '<br/>' . '<br/>';
                echo 'search result:';
                echo '<br/>';
                echo "<a href='view.php?id=$search_title'>$search_title</a>";
                //echo "<td><a href=\"" . $row['title'] . "\" alt='view.php'>$search_title</a></td>";
                /*            echo "<tr><td>{$row['title']}</td>";*/
                //echo "</tr>";
            }
        }else {
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "no content like this!" . "\"" . ")" . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "main.php" . "\"" . "</script>";
            exit;
        }
    } else {
        $this_content = $_POST['search_content'];
        $sql_search_title_by_content = "select title, content from note where  username = '$username_this' and content LIKE '%{$this_content}%' ";
        $like_content_this = $conn->query($sql_search_title_by_content);
        if ($like_content_this->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($like_content_this)) {
                $search_title_this = $row['title'];
                echo '<br/>' . '<br/>' . '<br/>';
                echo 'search result:';
                echo '<br/>';
                echo "<a href='view.php?id=$search_title_this'>$search_title_this</a>";
                /*            echo "<tr><td>{$row['title']}</td>";*/
                echo "</tr>";
            }
        } else {
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.alert" . "(" . "\"" . "no content like this!" . "\"" . ")" . ";" . "</script>";
            echo "<script type=" . "\"" . "text/javascript" . "\"" . ">" . "window.location=" . "\"" . "main.php" . "\"" . "</script>";
            exit;
        }

    }
}
$conn->close();
?>

</body>
</html>