<?php
include 'koneksi.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $query = "SELECT foto FROM postingan WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if($row) {
        $foto = $row['foto'];
        $path = "uploads/" . $foto;

        if(file_exists($path)){
            unlink($path);
        }

        $query_hapus = "DELETE FROM postingan WHERE id = '$id'";
        if(mysqli_query($conn, $query_hapus)){
            echo "<script>alert('Mantap! Data berhasil dihapus!'); window.location='index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: index.php");
}
?>