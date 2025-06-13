<?php
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM petugas WHERE username = '$username'";
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0){
    $data = mysqli_fetch_assoc($query);


    if(password_verify($password, $data['password'])){
        session_start();
        $_SESSION['id_petugas'] = $data['id_petugas'];
        $_SESSION['nama_petugas'] = $data['nama_petugas'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = $data['level'];
        if($data['level']=="admin"){
        header("Location:admin/admin.php");
        }elseif($data['level']=="petugas") {
            header("Location:petugas/petugas.php");
        }
        
    } else {
        echo "<script>alert('Password salah.'); window.location.assign('index2.php');</script>";
    }
} else {
    echo "<script>alert('Anda bukan Admin/Petugas.'); window.location.assign('index.php');</script>";
}
?>
