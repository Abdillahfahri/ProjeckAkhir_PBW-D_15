<?php
include 'db.php';

$nik = $_POST['nik'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$telp = $_POST['telp'];

$cek = mysqli_query($db, "SELECT * FROM masyarakat WHERE nik='$nik'");
if(mysqli_num_rows($cek) > 0){
    echo "<script>alert('NIK sudah terdaftar.'); window.location.assign('register.php');</script>";
    exit;
}

$sql = "INSERT INTO masyarakat(nik, nama, username, password, telp) 
        VALUES ('$nik', '$nama', '$username', '$password', '$telp')";

$query = mysqli_query($db, $sql);

if($query){
    echo "<script>alert('Registrasi berhasil!'); window.location.assign('index.php');</script>";
} else {
    echo "<script>alert('Registrasi gagal.'); window.location.assign('register.php');</script>";
}
?>
