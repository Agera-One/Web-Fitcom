<?php
include 'connection.php';

// Proses tambah data
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {

        // Ambil data dari form 
        $code = $_POST['code'];
        $name = $_POST['name'];
        $unit = $_POST['unit'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        
        // $clean = str_replace('.', '', $harga);
        // $angka = floatval($clean);
        // $price =  $result['price'];
        // $formatted = number_format($price, 2, ',', '.');

        // Upload gambar
        $target_dir = "Assets/Images/";
        $target_file = $target_dir . basename($image);
        $tmp_file = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_file, $target_file);

        // Escape string untuk menghindari SQL injection
        $code = mysqli_real_escape_string($connection, $code);
        $name = mysqli_real_escape_string($connection, $name);
        $unit = mysqli_real_escape_string($connection, $unit);
        $price = mysqli_real_escape_string($connection, $price);
        $image = mysqli_real_escape_string($connection, $image);

        // Query insert data ke database
        $query = "INSERT INTO produk (kode, nama, satuan, harga, gambar) VALUES ('$code', '$name', '$unit', '$price', '$image')";
        $sql = mysqli_query($connection, $query);

        if ($sql) {
            header("location: index.php");
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    } elseif ($_POST['action'] == 'change') {
        // Ambil data dari form
        $no = $_POST['no'];
        $code = $_POST['code'];
        $name = $_POST['name'];
        $unit = $_POST['unit'];
        $price = $_POST['price'];

        // Ambil data gambar lama dari database
        $queryShow = "SELECT gambar FROM produk WHERE no = '$no';";
        $sqlShow = mysqli_query($connection, $queryShow);
        $result = mysqli_fetch_assoc($sqlShow);
        $imagePath = "Assets/Images/" . $result['gambar'];

        // Escape string untuk menghindari SQL injection
        $no = mysqli_real_escape_string($connection, $no);
        $code = mysqli_real_escape_string($connection, $code);
        $name = mysqli_real_escape_string($connection, $name);
        $unit = mysqli_real_escape_string($connection, $unit);
        $price = mysqli_real_escape_string($connection, $price);

        // Cek apakah ada file gambar yang diupload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            $target_dir = "Assets/Images/";
            $target_file = $target_dir . basename($image);
            $tmp_file = $_FILES['image']['tmp_name'];
            move_uploaded_file($tmp_file, $target_file);
            $imagePath = "Assets/Images/" . $result['gambar'];

            $image = mysqli_real_escape_string($connection, $image);

            // Hapus file gambar lama dari server
            if (file_exists($imagePath)) {
                unlink($imagePath); // Hapus file gambar dari server
            }

            // Update data termasuk gambar
            $query = "UPDATE produk SET kode='$code', nama='$name', satuan='$unit', harga='$price', gambar='$image' WHERE no = '$no';";
            $sql = mysqli_query($connection, $query);

            if ($sql) {
                header("location: index.php");
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($connection);
            }
        } else {
            // Update data tanpa mengubah gambar
            $query = "UPDATE produk SET kode='$code', nama='$name', satuan='$unit', harga='$price' WHERE no = '$no';";
            $sql = mysqli_query($connection, $query);

            if ($sql) {
                header("location: index.php");
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($connection);
            }
        }
    }
}


// Proses hapus data
if (isset($_GET['remove'])) {
    $no = $_GET['remove'];

    // Hapus file gambar terkait dari server
    $queryShow = "SELECT gambar FROM produk WHERE no = '$no';";
    $sqlShow = mysqli_query($connection, $queryShow);
    $result = mysqli_fetch_assoc($sqlShow);
    $imagePath = "Assets/Images/" . $result['gambar'];
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