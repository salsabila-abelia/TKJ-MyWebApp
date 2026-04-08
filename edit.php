<?php
include 'koneksi.php';

// Ambil ID dari URL saat pertama kali buka halaman edit
if(!isset($_GET['id'])){ header("Location: index.php"); exit; }
$id = $_GET['id'];

$query = "SELECT * FROM postingan WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if(!$data){ echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>"; exit; }

// Proses jika tombol Simpan Perubahan diklik
if(isset($_POST['update'])){
    // Tangkap ID dari Hidden Input biar nggak mungkin hilang
    $id_post = $_POST['id_postingan']; 
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Cek dengan lebih aman: error === 0 artinya ada file yang BERHASIL diupload
    if($_FILES['foto']['error'] === 0){
        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $nama_file_baru = time() . "_" . $nama_file;
        $path = "uploads/" . $nama_file_baru;

        if(move_uploaded_file($tmp_file, $path)){
            // Hapus foto lama
            $foto_lama = "uploads/" . $data['foto'];
            if(file_exists($foto_lama)){ unlink($foto_lama); }
            
            // Update beserta foto baru
            $query_update = "UPDATE postingan SET judul='$judul', deskripsi='$deskripsi', foto='$nama_file_baru' WHERE id='$id_post'";
        }
    } else {
        // Kalau nggak ada foto baru, update teksnya aja (foto lama aman)
        $query_update = "UPDATE postingan SET judul='$judul', deskripsi='$deskripsi' WHERE id='$id_post'";
    }

    if(mysqli_query($conn, $query_update)){
        echo "<script>alert('Mantap! Data berhasil diupdate!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Wah gagal: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Postingan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gradient-main: linear-gradient(135deg, #FF80BF 0%, #944DFF 50%, #4DFFFF 100%);
            --primary: #751AFF; 
            --primary-hover: #5C00E6;
            --bg-color: #F8FAFC;
        }

        body { 
            font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background-color: var(--bg-color); 
            background-image: linear-gradient(135deg, rgba(255, 128, 191, 0.1) 0%, rgba(148, 77, 255, 0.1) 50%, rgba(77, 255, 255, 0.1) 100%);
            color: #1E293B; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; box-sizing: border-box;
        }

        .form-card { 
            background: rgba(255, 255, 255, 0.9); padding: 35px; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); 
            width: 100%; max-width: 550px; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(5px);
        }

        h2 { text-align: center; margin-top: 0; color: var(--primary); margin-bottom: 30px; font-size: 24px; font-weight: 700; }

        .form-group { margin-bottom: 25px; }
        label { display: block; font-weight: 600; margin-bottom: 10px; font-size: 14px; }
        
        .form-control { 
            width: 100%; padding: 14px 18px; border: 2px solid #E2E8F0; border-radius: 10px; 
            font-family: 'Poppins', sans-serif; font-size: 14px; box-sizing: border-box; transition: all 0.3s ease; background-color: white;
        }
        .form-control:focus { outline: none; border-color: #944DFF; box-shadow: 0 0 0 4px rgba(148, 77, 255, 0.2); }

        button { 
            width: 100%; padding: 16px 20px; background-color: var(--primary); color: white; border: none; border-radius: 10px; 
            font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s ease; font-family: 'Poppins', sans-serif;
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;
        }
        button:hover { background-color: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(117, 26, 255, 0.3); }

        .btn-kembali { display: block; text-align: center; text-decoration: none; color: #64748B; font-size: 14px; margin-top: 15px; font-weight: 500; transition: color 0.3s; }
        .btn-kembali:hover { color: var(--primary); }

        .foto-lama { max-width: 120px; border-radius: 10px; margin-top: 15px; display: block; border: 2px solid #E2E8F0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Edit Postingan</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="id_postingan" value="<?php echo $data['id']; ?>">

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="judul" class="form-control" required value="<?php echo htmlspecialchars($data['judul']); ?>">
        </div>
        <div class="form-group">
            <label>Ceritakan Sesuatu</label>
            <textarea name="deskripsi" class="form-control" rows="4" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Ganti Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small style="display:block; margin-top:10px;">Foto saat ini:</small>
            <img src="uploads/<?php echo $data['foto']; ?>" class="foto-lama" alt="Foto Lama">
        </div>
        <button type="submit" name="update">Simpan Perubahan</button>
        <a href="index.php" class="btn-kembali">← Batal dan Kembali</a>
    </form>
</div>

</body>
</html>