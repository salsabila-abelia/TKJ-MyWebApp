<?php
include 'koneksi.php';

// Pastikan tombol submit sudah ditekan
if (isset($_POST['submit'])) {
    // Ambil data teks dari form
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Ambil data file foto
    $nama_file = $_FILES['foto']['name'];
    $tmp_file = $_FILES['foto']['tmp_name'];

    // Rename file supaya tidak ada nama file yang sama (menambahkan angka timestamp)
    $nama_file_baru = time() . "_" . $nama_file;
    
    // Tentukan folder tujuan upload
    $path = "uploads/" . $nama_file_baru;

    // Proses pemindahan file dari temporary ke folder uploads
    if (move_uploaded_file($tmp_file, $path)) {
        
        // Jika file berhasil dipindah, masukkan data ke database
        $query = "INSERT INTO postingan (judul, deskripsi, foto) VALUES ('$judul', '$deskripsi', '$nama_file_baru')";
        $eksekusi = mysqli_query($conn, $query);

        if ($eksekusi) {
            // Berhasil
            echo "<script>alert('Postingan berhasil ditambahkan!'); window.location='index.php';</script>";
        } else {
            // Gagal input database
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Gagal upload file
        echo "<script>alert('Gagal mengupload foto! Pastikan folder uploads sudah dibuat.'); window.location='index.php';</script>";
    }
} else {
    // Jika ada yang mencoba akses proses.php langsung lewat URL, tendang kembali ke index
    header("Location: index.php");
}
?>