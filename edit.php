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
    $id_post = $_POST['id_postingan']; 
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    if($_FILES['foto']['error'] === 0){
        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $nama_file_baru = time() . "_" . $nama_file;
        $path = "uploads/" . $nama_file_baru;

        if(move_uploaded_file($tmp_file, $path)){
            $foto_lama = "uploads/" . $data['foto'];
            if(file_exists($foto_lama)){ unlink($foto_lama); }
            $query_update = "UPDATE postingan SET judul='$judul', deskripsi='$deskripsi', foto='$nama_file_baru' WHERE id='$id_post'";
        }
    } else {
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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- Variabel Warna Pastel & Animasi --- */
        :root {
            --pink-pastel: #FFD1DC;
            --purple-pastel: #E6E6FA;
            --blue-pastel: #D4F0F0;
            --yellow-pastel: #FDFD96;
            --main-accent: #8A70FF;
            --text-color: #5D5D5D;
            --text-muted: #9B82C6;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes popUpModal {
            0% { transform: scale(0.5) translateY(100px); opacity: 0; }
            60% { transform: scale(1.05) translateY(-10px); opacity: 1; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }

        @keyframes hologramGlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body { 
            font-family: 'Quicksand', sans-serif; 
            margin: 0; padding: 0; 
            background: linear-gradient(-45deg, var(--pink-pastel), var(--purple-pastel), var(--blue-pastel), var(--yellow-pastel));
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: var(--text-color); display: flex; 
            justify-content: center; align-items: center; 
            min-height: 100vh; padding: 20px; box-sizing: border-box;
            overflow-x: hidden;
        }

        /* Desain Kotak Form Ala Glassy Glass */
        .form-card { 
            background: rgba(255, 255, 255, 0.45); 
            padding: 40px; border-radius: 25px; 
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05), inset 0 0 0 2px rgba(255, 255, 255, 0.8); 
            width: 100%; max-width: 500px; 
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            /* Memanggil efek animasi Pop Up */
            animation: popUpModal 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }

        h2 { 
            text-align: center; margin-top: 0; 
            color: var(--main-accent); margin-bottom: 30px; 
            font-size: 28px; font-weight: 700;
            text-shadow: 2px 2px 4px rgba(255,255,255,0.7);
        }

        .form-group { margin-bottom: 25px; position: relative; }
        
        label { 
            display: block; font-weight: 700; 
            margin-bottom: 8px; font-size: 15px; 
            color: var(--text-muted); margin-left: 5px;
        }
        
        .form-control { 
            width: 100%; padding: 15px 20px; 
            border: 2px solid rgba(255, 255, 255, 0.6); 
            border-radius: 15px; font-family: 'Quicksand', sans-serif; 
            font-size: 15px; box-sizing: border-box; 
            transition: all 0.4s ease; background: rgba(255, 255, 255, 0.6);
            color: #555; box-shadow: inset 0 2px 5px rgba(0,0,0,0.02);
        }

        .form-control:focus { 
            outline: none; border-color: #A3C4F3; 
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 15px rgba(163, 196, 243, 0.5); 
            transform: translateY(-2px);
        }

        /* Tombol Hologram Mengkilap */
        button { 
            width: 100%; padding: 16px 20px; 
            background: linear-gradient(135deg, #FFB7B2, #E2F0CB, #B5EAD7, #C7CEEA);
            background-size: 300% 300%;
            animation: hologramGlow 4s ease infinite;
            color: #555; border: 2px solid rgba(255, 255, 255, 0.8); 
            border-radius: 15px; font-weight: 700; 
            font-size: 17px; cursor: pointer; 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            font-family: 'Quicksand', sans-serif;
            letter-spacing: 1.5px; margin-top: 10px;
            margin-bottom: 15px; box-shadow: 0 10px 20px rgba(199, 206, 234, 0.5);
        }

        button:hover { 
            transform: translateY(-5px) scale(1.02); 
            box-shadow: 0 15px 25px rgba(199, 206, 234, 0.8); 
            color: var(--main-accent);
        }

        .btn-kembali { 
            display: block; text-align: center; 
            text-decoration: none; color: var(--text-muted); 
            font-size: 15px; font-weight: 600; 
            transition: all 0.3s; 
        }

        .btn-kembali:hover { color: #FF9AA2; letter-spacing: 1px; }

        .foto-container {
            display: flex; align-items: center; gap: 15px;
            margin-top: 15px; background: rgba(255, 255, 255, 0.5);
            padding: 10px; border-radius: 15px; border: 1px dashed rgba(138, 112, 255, 0.3);
        }

        .foto-lama { 
            max-width: 90px; border-radius: 12px; 
            box-shadow: 0 8px 15px rgba(0,0,0,0.1); 
            transition: transform 0.3s ease;
        }

        .foto-lama:hover { transform: scale(1.1) rotate(2deg); }

        .foto-teks { font-size: 13px; color: var(--text-muted); }
    </style>
</head>
<body>

<div class="form-card">
    <h2>✨ Edit Postingan</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="id_postingan" value="<?php echo $data['id']; ?>">

        <div class="form-group">
            <label>Nama Anda</label>
            <input type="text" name="judul" class="form-control" required value="<?php echo htmlspecialchars($data['judul']); ?>">
        </div>
        <div class="form-group">
            <label>Ceritakan Sesuatu</label>
            <textarea name="deskripsi" class="form-control" rows="4" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
        </div>
        <div class="form-group">
            <label>Ganti Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            
            <div class="foto-container">
                <img src="uploads/<?php echo $data['foto']; ?>" class="foto-lama" alt="Foto Lama">
                <div class="foto-teks">Ini adalah foto kamu saat ini.<br>Biarkan kosong jika tidak ingin mengganti.</div>
            </div>
        </div>
        <button type="submit" name="update">Simpan Perubahan</button>
        <a href="index.php" class="btn-kembali">← Batal dan Kembali</a>
    </form>
</div>

</body>
</html>