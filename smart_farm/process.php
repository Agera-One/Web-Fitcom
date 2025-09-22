<?php
include 'connection.php';

// Proses tambah data
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {

        // Ambil data dari form 
        $kode = $_POST['code'];
        $nama = $_POST['name'];
        $satuan = $_POST['unit'];
        $harga = $_POST['price'];
        $gambar = $_FILES['image']['name'];
        
        // Upload gambar
        $target_dir = "Assets/Images/";
        $target_file = $target_dir . basename($gambar);
        $tmp_file = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_file, $target_file);
        
        // Escape string untuk menghindari SQL injection
        $kode = mysqli_real_escape_string($connection, $kode);
        $nama = mysqli_real_escape_string($connection, $nama);
        $satuan = mysqli_real_escape_string($connection, $satuan);
        $harga = mysqli_real_escape_string($connection, $harga);
        $gambar = mysqli_real_escape_string($connection, $gambar);

        // Query insert data ke database
        $query = "INSERT INTO produk (kode, nama, satuan, harga, gambar) VALUES ('$kode', '$nama', '$satuan', '$harga', '$gambar')";
        $sql = mysqli_query($connection, $query);

        if ($sql) {
            header("location: index.php");
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    } elseif ($_POST['change'] == 'change') {
        echo "ubah data";
    }
}


// Proses hapus data
if (isset($_GET['remove'])) {
    $no = $_GET['remove'];

    // Hapus file gambar terkait dari server
    $queryShow = "SELECT gambar FROM produk WHERE no = '$no';";
    $sqlShow = mysqli_query($connection, $queryShow);
    $data = mysqli_fetch_assoc($sqlShow);
    $imagePath = "Assets/Images/" . $data['gambar'];
    if (file_exists($imagePath)) {
        unlink($imagePath); // Hapus file gambar dari server
    }
    // Hapus data dari database
    $query = "DELETE FROM produk WHERE no = '$no'";
    $sql = mysqli_query($connection, $query);

    if ($sql) {
        header("location: index.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
}
