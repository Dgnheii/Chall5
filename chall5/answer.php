<?php
    require './libs/homeworks.php';
    session_start();
    disconnect_db();
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $_SESSION['hw_id'] = $id;
    $data = getName($id);
    $tenbai = $data['name'];
    // $table = "answer";
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $error = array();
        $file = $_FILES['Answer'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg','jpeg','png','gif','pdf','docx','zip','rar');
        if (in_array($fileActualExt,$allowed)){
            if ($fileError === 0){
                //$fileNameNew = md5($fileName).'.'.$fileActualExt;
                $fileDestination = 'uploads/answer/'.$fileName;
                move_uploaded_file($fileTmpName,$fileDestination);
            }
            upload_ans($_SESSION['hw_id'], $tenbai, $_SESSION['username'], $fileDestination);
        }
    }   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tenbai; ?></title>
    <style type="text/css">
            body {
                background: linear-gradient(90deg,  rgba(66, 183, 245,0.8) 0%,rgba(66, 245, 189,0.4) 100%);;
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
    <h1><?php echo $tenbai; ?></h1>
    <a href="homework.php">Homework</a></br></br>
    <?php if($_SESSION['role'] == 0) { ?>
    <div id="content">
        <form id="Answer" method="POST" enctype="multipart/form-data">
            <input type="file" name="Answer"  id="Answer" >
            <input type="submit" name="submit" value="Upload"><br/>
        </form></br>
    </div>
    <?php } ?>
    <table width="90%" border="1" cellspacing="0" cellpadding="10   ">
        <tr>
            <td>File</td>
            <td>Option</td>
        </tr>
        <?php
            $data2 = getFileByID($id);
            foreach ($data2 as $a) { ?>
        <tr>
            <td> <a href="<?php echo $a['folder'];?>"></a><?php echo $a['folder'];?></td>
            <td>
                <?php if($_SESSION['role'] == 0) { ?>
                <form method="post" action="homework-delete.php">
                    <input type="hidden" name="id" value="<?php echo $a['id']; ?>"/>                 
                    <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                </form>
                <?php } else { ?>
                    <a href="<?php echo $a['folder'];?>"><button name="download">View</button></a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>