<?php
global $conn;

function connect_db()
{
    global $conn;
    if (!$conn){
        $conn = mysqli_connect('localhost', 'root', 'vertrigo', 'qlsv') or die ('Can\'t not connect to database');
        mysqli_set_charset($conn, 'utf8');
    }
}
 
function disconnect_db()
{
    global $conn;
    if ($conn){
        mysqli_close($conn);
    }
}

function get_all_students()
{
    global $conn;
    connect_db();
    $sql = "select * from sinhvien where role = 0 ";
    $query = mysqli_query($conn, $sql);
    $result = array();
    if ($query){
        while ($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
    return $result;
}
 
function get_student($username)
{
    global $conn;
    connect_db();
    $sql = "select * from sinhvien where username = '$username' and role = 0 ";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    return $result;
}

function get_teacher($username)
{
    global $conn;
    connect_db();

    $username = mysqli_real_escape_string($conn, $username);
    $sql = "select * from sinhvien where username = '$username' and role = 1 ";
    
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    return $result;
}
 
function add_student($username,$password, $name, $email, $phone)
{
    global $conn;
    connect_db();
    
    $username = mysqli_real_escape_string($conn, htmlentities($username));
    $password = mysqli_real_escape_string($conn, htmlentities($password));
    $name = mysqli_real_escape_string($conn, htmlentities($name));
    $email = mysqli_real_escape_string($conn, htmlentities($email));
    $phone = mysqli_real_escape_string($conn, htmlentities($phone));

    $sql = "
            INSERT INTO sinhvien(username,password, name, email, phone, role) VALUES
            ('$username','$password', '$name', '$email', '$phone', '0')
    ";
    $query = mysqli_query($conn, $sql);
    return $query;
}
 
function edit_student($currentName, $username,$password, $name, $email, $phone, $role)
{
    global $conn;
    connect_db();

    $currentName = mysqli_real_escape_string($conn, htmlentities($currentName));
    $username = mysqli_real_escape_string($conn, htmlentities($username));
    $password = mysqli_real_escape_string($conn, htmlentities($password));
    $name = mysqli_real_escape_string($conn, htmlentities($name));
    $email = mysqli_real_escape_string($conn, htmlentities($email));
    $phone = mysqli_real_escape_string($conn, htmlentities($phone));
    $role = mysqli_real_escape_string($conn, htmlentities($role));

    $sql = "
            UPDATE sinhvien SET
            username = '$username',
            password = '$password',
            name = '$name',
            email = '$email',
            phone = '$phone',
            role = $role
            WHERE username = '$currentName'
    ";
    $query = mysqli_query($conn, $sql);
    return $query;
}
 
function delete_student($username)
{
    global $conn;
    connect_db();
    $username = mysqli_real_escape_string($conn, $username);
    $sql = "
            DELETE FROM sinhvien
            WHERE username = '$username'
    ";
    $query = mysqli_query($conn, $sql);
     
    return $query;
}

?>