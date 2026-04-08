<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Proyekku</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gradient-main: linear-gradient(135deg, #FF80BF 0%, #944DFF 50%, #4DFFFF 100%);
            --primary: #751AFF; 
            --primary-hover: #5C00E6;
            --bg-color: #F8FAFC; 
            --card-bg: rgba(255, 255, 255, 0.9); 
            --text-dark: #1E293B;
            --text-muted: #64748B;
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            padding: 0;
            background-color: var(--bg-color); 
            background-image: linear-gradient(135deg, rgba(255, 128, 191, 0.1) 0%, rgba(148, 77, 255, 0.1) 50%, rgba(77, 255, 255, 0.1) 100%);
            color: var(--text-dark); 
        }

        .header {
            background: var(--gradient-main);
            color: white;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);
            margin-bottom: 50px;
        }
        
        .header h1 { margin: 0; font-size: 36px; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.2); }
        .header p { margin: 12px 0 0 0; opacity: 0.9; font-weight: 300; font-size: 16px; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        .form-card { 
            background: var(--card-bg); 
            padding: 35px; 
            border-radius: 20px; 
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); 
            margin-bottom: 60px; 
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid rgba(255,255,255,0.3); 
            backdrop-filter: blur(5px); 
        }

        .form-card h2 { margin-top: 0; color: var(--primary); text-align: center; margin-bottom: 30px; font-size: 24px; }

        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 10px; font-size: 14px; color: var(--text-dark); }
        
        .form-control { 
            width: 100%; padding: 14px 18px; border: 2px solid #E2E8F0; border-radius: 10px; 
            font-family: 'Poppins', sans-serif; font-size: 14px; box-sizing: border-box; transition: all 0.3s ease; background-color: white;
        }
        .form-control:focus { outline: none; border-color: #944DFF; box-shadow: 0 0 0 4px rgba(148, 77, 255, 0.2); }

        button { 
            width: 100%; padding: 16px 20px; background-color: var(--primary); color: white; border: none; border-radius: 10px; 
            font-weight: 700; font-size: 16px; cursor: pointer; transition: all 0.3s ease; font-family: 'Poppins', sans-serif;
            text-transform: uppercase; letter-spacing: 1px;
        }
        button:hover { background-color: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(117, 26, 255, 0.3); }

        .section-title {
            text-align: center; margin-bottom: 40px; font-size: 28px; font-weight: 700;
            background: var(--gradient-main); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .grid-post { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; padding-bottom: 80px; }

        .card { 
            background: var(--card-bg); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); 
            transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column; border: 1px solid rgba(255,255,255,0.2);
        }
        .card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15); }
        .card img { width: 100%; height: 240px; object-fit: cover; border-bottom: 2px solid rgba(148, 77, 255, 0.2); }

        .card-body { padding: 25px; display: flex; flex-direction: column; flex-grow: 1; }
        .card h3 { margin: 0 0 12px 0; font-size: 20px; color: var(--primary); font-weight: 600; }
        .card p { color: var(--text-muted); font-size: 15px; line-height: 1.7; margin-bottom: 20px; flex-grow: 1; }
        .card small { color: #94A3B8; font-size: 12px; border-top: 1px solid #E2E8F0; padding-top: 12px; display: block; font-weight: 300; }

        .action-buttons { display: flex; gap: 12px; margin-top: 18px; }
        .btn-edit, .btn-delete {
            padding: 10px 15px; font-size: 13px; text-decoration: none; border-radius: 8px; text-align: center; flex: 1; color: white;
            font-weight: 600; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .btn-edit { background-color: #F59E0B; } 
        .btn-edit:hover { background-color: #D97706; transform: translateY(-2px); }
        .btn-delete { background-color: #EF4444; } 
        .btn-delete:hover { background-color: #DC2626; transform: translateY(-2px); }

        @media (max-width: 600px) {
            .grid-post { grid-template-columns: 1fr; }
            .header h1 { font-size: 28px; }
            .form-card { padding: 25px; }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>🚀 My Web App</h1>
    <p>Simpan momen dan catatan proyekmu di sini</p>
</div>

<div class="container">
    <div class="form-card">
        <h2>Buat Postingan Baru</h2>
        <form action="proses.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="judul" class="form-control" required placeholder="Ketik nama kamu di sini...">
            </div>
            <div class="form-group">
                <label>Ceritakan Sesuatu</label>
                <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Apa yang sedang kamu kerjakan?"></textarea>
            </div>
            <div class="form-group">
                <label>Upload Foto Pendukung</label>
                <input type="file" name="foto" class="form-control" accept="image/*" required style="padding: 9px 15px;">
            </div>
            <button type="submit" name="submit">Bagikan Sekarang</button>
        </form>
    </div>

    <h2 class="section-title">Galeri Proyek Terbaru</h2>
    
    <div class="grid-post">
        <?php
        $query = "SELECT * FROM postingan ORDER BY dibuat_pada DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card'>";
                echo "<img src='uploads/" . htmlspecialchars($row['foto']) . "' alt='Foto'>";
                echo "<div class='card-body'>";
                echo "<h3>" . htmlspecialchars($row['judul']) . "</h3>";
                echo "<p>" . nl2br(htmlspecialchars($row['deskripsi'])) . "</p>";
                
                $tanggal = date('d M Y, H:i', strtotime($row['dibuat_pada']));
                echo "<small>Diupload: " . $tanggal . "</small>";
                
                // Tombol Edit & Hapus
                echo "<div class='action-buttons'>";
                echo "<a href='edit.php?id=" . $row['id'] . "' class='btn-edit'>✏️ Edit</a>";
                echo "<a href='hapus.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Yakin mau hapus data ini?\")'>🗑️ Hapus</a>";
                echo "</div>";

                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p style='text-align:center; grid-column: 1 / -1; color: #64748B;'>Belum ada postingan. Ayo buat yang pertama!</p>";
        }
        ?>
    </div>
</div>

</body>
</html>