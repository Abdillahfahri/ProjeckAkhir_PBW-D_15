<?php
include 'db.php';

$nik = $_POST['nik'];
$password = $_POST['password'];


$sql = "SELECT * FROM masyarakat WHERE nik = '$nik'";
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0){
    $data = mysqli_fetch_assoc($query);


    if(password_verify($password, $data['password'])){
        session_start();
        $_SESSION['nik'] = $data['nik'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['username'] = $data['username'];

        header("Location: masyarakat.php");
        exit;
    } else {
        echo "<script>alert('Password salah.'); window.location.assign('index.php');</script>";
    }
} else {
    echo "<script>alert('NIK tidak ditemukan.'); window.location.assign('index.php');</script>";
}
?>
