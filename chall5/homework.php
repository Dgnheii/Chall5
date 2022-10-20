<?php
    require './libs/homeworks.php';
    session_start();
    disconnect_db();
    $table = "homework";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $hwname = isset($_POST['hwname']) ? $_POST['hwname'] : '';
        $error = array();
        $file = $_FILES['Homework'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg','jpeg','png','gif','pdf','docx','zip','rar');
        if (in_array($fileActualExt,$allowed)){
            if ($fileError === 0){
                if ($fileSize < 1000000){
                    $fileNameNew = md5($fileName).'.'.$fileActualExt;
                    $fileDestination = 'uploads/homework/'.$fileName;
                    move_uploaded_file($fileTmpName,$fileDestination);
                }
            }
            upload_ques($_SESSION['username'],$hwname, $fileDestination);
        }
    }   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homework</title>
    <style type="text/css">
            body {
                background: #bff;
            }
            button {
                background: #b8e1ff;
            }
            input {
                background: #b8e1ff;    
            }
        </style>
</head>
<body>
    <h1>Homework</h1>
    <a href="home.php">Home</a></br></br>
    <?php if($_SESSION['role'] == 1) { ?>
    <div id="content">
        <form id="Homework" method="POST" enctype="multipart/form-data">
            Tên bài: <input type="text" name="hwname"> </br> </br>
            <input type="file" name="Homework"  id="Homework" >
            <input type="submit" name="submit" value="Upload"><br/>
        </form></br>
    </div>
    <?php } ?>
    <table width="90%" border="1" cellspacing="0" cellpadding="10   ">
        <tr>
            <td>Homework</td>
            <td>Option</td>
        </tr>
        <?php
            $data = get_all_file($table);
            foreach ($data as $a) { ?>
        <tr>
            <td> <?php echo $a['name']; ?> </td>
            <td> 
                <a href="<?php echo $a['folder'];?>"><button name="download">View</button></a>
                <?php if($_SESSION['role'] == 1) { ?>
                    <a href="answer.php?id=<?php echo $a['id']; ?>"><button name="view">View Answer</button></a></br></br>
                <form method="post" action="homework-delete.php">
                    <input type="hidden" name="id" value="<?php echo $a['id']; ?>"/>                   
                    <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                </form>
                <?php } else { ?> 
                    <input onclick="window.location = 'answer.php?id=<?php echo $a['id']; ?>'" type="button" value="Nộp Bài"/>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>