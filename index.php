<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✨ Galeri Proyek Estetik✨</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- Mantra Warna & Animasi --- */
        :root {
            --pink-deep: #FFB7B2;
            --purple-deep: #B5A2FF;
            --blue-deep: #A2E1FF;
            --main-accent: #B5A2FF;
            --text-color: #5D5D5D; 
            --text-muted: #8E7AB5;
            
            --glass-bg: rgba(255, 255, 255, 0.3);
            --glass-border: rgba(255, 255, 255, 0.6);
            --glass-shadow: rgba(181, 162, 255, 0.2);
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes popUpModal {
            0% { transform: scale(0.5) translateY(50px); opacity: 0; }
            60% { transform: scale(1.02) translateY(-10px); opacity: 1; }
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
            background: linear-gradient(-45deg, #FFD1DC, #E6E6FA, #D4F0F0, #FFC4E1);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: var(--text-color); 
            min-height: 100vh;
            overflow-x: hidden;
            letter-spacing: 0.3px;
        }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px 100px 20px; }

        .header {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            border-bottom: 2px solid var(--glass-border);
            padding: 50px 20px; text-align: center; margin-bottom: 60px;
            animation: fadeInDown 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            box-shadow: 0 10px 40px var(--glass-shadow);
            position: relative; z-index: 10;
        }
        
        .header h1 { 
            margin: 0; font-size: 42px; font-weight: 700; color: var(--main-accent);
            text-shadow: 2px 2px 5px rgba(255,255,255,0.8), 0 0 15px rgba(181, 162, 255, 0.3); 
            letter-spacing: 1.5px;
        }
        
        .header p { 
            margin: 15px 0 0 0; font-weight: 600; font-size: 20px; color: var(--text-muted); 
            min-height: 30px;
            text-shadow: 1px 1px 2px rgba(255,255,255,0.6);
        }

        .typed-cursor {
            color: #FF80BF;
            font-size: 22px;
            text-shadow: 0 0 10px rgba(255, 128, 191, 0.7);
        }

        .btn-add-popup {
            position: fixed; bottom: 40px; right: 40px;
            padding: 18px 30px;
            background: linear-gradient(135deg, #FFB7B2, #E6E6FA, #D4F0F0);
            background-size: 300% 300%;
            animation: hologramGlow 4s ease infinite;
            color: #555; 
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 50px; font-weight: 700; font-size: 19px;
            cursor: pointer; 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            font-family: 'Quicksand', sans-serif; letter-spacing: 1.2px;
            box-shadow: 0 12px 25px rgba(181, 162, 255, 0.4);
            z-index: 100; text-transform: uppercase;
        }
        .btn-add-popup:hover { 
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 18px 35px rgba(181, 162, 255, 0.6);
            color: var(--main-accent);
        }

        .modal {
            display: none; position: fixed; z-index: 1000; left: 0; top: 0;
            width: 100%; height: 100%; overflow: auto;
            background-color: rgba(181, 162, 255, 0.1);
            backdrop-filter: blur(10px) saturate(150%);
            -webkit-backdrop-filter: blur(10px) saturate(150%);
        }
        .modal-content {
            background: rgba(255, 255, 255, 0.35);
            padding: 50px 40px; border-radius: 30px;
            box-shadow: 0 20px 50px var(--glass-shadow), inset 0 0 0 2px var(--glass-border);
            width: 100%; max-width: 600px;
            margin: 8% auto;
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            animation: popUpModal 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
            position: relative;
            border: 1px solid var(--glass-border);
        }
        .close-modal {
            position: absolute; top: 25px; right: 30px;
            font-size: 32px; font-weight: bold; 
            background: linear-gradient(135deg, #FF9AA2, #B5A2FF);
            -webkit-background-clip: text; background-clip: text; color: transparent;
            cursor: pointer; transition: all 0.3s ease;
        }
        .close-modal:hover { color: #FF9AA2; transform: scale(1.2) rotate(90deg); }

        .form-card h2 { 
            margin-top: 0; color: var(--main-accent); text-align: center;
            margin-bottom: 35px; font-size: 28px; font-weight: 700;
        }

        .form-group { margin-bottom: 30px; }

        /* --- LABEL TEKS GRADASI GELAP BANGET --- */
        .form-group label { 
            display: block; 
            font-weight: 800; /* Dibuat lebih tebal */
            margin-bottom: 12px; 
            font-size: 16px;
            margin-left: 10px;
            /* Pakai warna Midnight / Deep Gradient */
            background: linear-gradient(135deg, #880E4F 0%, #311B92 50%, #0D47A1 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 0.8px;
        }
        
        .form-control { 
            width: 100%; padding: 18px 25px;
            border: 2px solid rgba(255, 255, 255, 0.4); 
            border-radius: 18px;
            font-family: 'Quicksand', sans-serif; font-size: 16px;
            box-sizing: border-box; 
            transition: all 0.4s ease;
            background: rgba(255, 255, 255, 0.4); color: #222; /* Teks input juga digelapkan */
            font-weight: 600;
        }
        .form-control:focus { 
            outline: none; 
            border-color: #B5A2FF;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 15px rgba(181, 162, 255, 0.4);
            transform: translateY(-2px);
        }

        .btn-submit { 
            width: 100%; padding: 18px 25px;
            background: linear-gradient(135deg, #FFB7B2, #E6E6FA, #D4F0F0);
            background-size: 300% 300%;
            animation: hologramGlow 4s ease infinite;
            color: #555; border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 18px; font-weight: 700; font-size: 18px;
            cursor: pointer; transition: all 0.4s ease;
            font-family: 'Quicksand', sans-serif; letter-spacing: 1.8px;
            text-transform: uppercase;
        }

        .grid-post { 
            display: grid; grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
            gap: 40px; padding-bottom: 20px;
        }

        .card { 
            background: rgba(255, 255, 255, 0.35); border-radius: 28px;
            overflow: hidden; 
            box-shadow: 0 15px 40px rgba(0,0,0,0.04), inset 0 0 0 2px var(--glass-border);
            backdrop-filter: blur(12px) saturate(160%);
            -webkit-backdrop-filter: blur(12px) saturate(160%);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex; flex-direction: column;
            animation: fadeInUp 0.8s ease forwards; opacity: 0;
            border: 1px solid var(--glass-border);
        }
        .card:hover { 
            transform: translateY(-15px) scale(1.03);
            box-shadow: 0 30px 50px rgba(181, 162, 255, 0.4);
        }
        
        .card img { 
            width: 100%; height: 260px; object-fit: cover;
            border-bottom: 2px solid rgba(255, 255, 255, 0.6);
        }

        .card-body { padding: 30px; display: flex; flex-direction: column; flex-grow: 1; z-index: 1; background: inherit; }
        .card h3 { margin: 0 0 15px 0; font-size: 24px; color: var(--main-accent); font-weight: 700; }
        .card p { color: var(--text-color); font-size: 16px; line-height: 1.8; margin-bottom: 25px; flex-grow: 1; font-weight: 500;}
        .card small { color: var(--text-muted); font-size: 13px; border-top: 1px dashed rgba(181, 162, 255, 0.3); padding-top: 18px; display: block; font-weight: 600; }

        .action-buttons { display: flex; gap: 18px; margin-top: 25px; }
        .btn-edit, .btn-delete {
            padding: 14px 18px; font-size: 14px; text-decoration: none;
            border-radius: 14px; text-align: center; flex: 1;
            font-weight: 700; transition: all 0.3s ease;
        }
        .btn-edit { background: linear-gradient(135deg, #FFF9D4, #FDE68A); color: #92400E; } 
        .btn-delete { background: linear-gradient(135deg, #FFE4E4, #FECACA); color: #991B1B; }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }

        ::-webkit-scrollbar { width: 10px; background-color: rgba(255,255,255,0.3); }
        ::-webkit-scrollbar-thumb { background: linear-gradient(#FFB7B2, #B5A2FF); border-radius: 10px; }

        @media (max-width: 600px) {
            .grid-post { grid-template-columns: 1fr; gap: 30px; }
            .header h1 { font-size: 32px; }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>🚀 My Web App</h1>
    <p><span id="teks-animasi"></span></p>
</div>

<button class="btn-add-popup" id="openModalBtn">+ Buat Postingan ✨</button>

<div class="container">
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
                
                echo "<div class='action-buttons'>";
                echo "<a href='edit.php?id=" . $row['id'] . "' class='btn-edit'>✏️ Edit</a>";
                echo "<a href='hapus.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Yakin mau hapus data ini?\")'>🗑️ Hapus</a>";
                echo "</div>";

                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p style='text-align:center; grid-column: 1 / -1; color: var(--text-muted); font-weight: 600; font-size: 18px;'>Belum ada postingan. Ayo buat yang pertama!</p>";
        }
        ?>
    </div>
</div>

<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" id="closeModalBtn">&times;</span>
        <div class="form-card">
            <h2>Buat Postingan Baru ✨</h2>
            <form action="proses.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Anda</label>
                    <input type="text" name="judul" class="form-control" required placeholder="Ketik nama kamu di sini...">
                </div>
                <div class="form-group">
                    <label>Ceritakan Sesuatu</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Apa yang sedang kamu kerjakan?"></textarea>
                </div>
                <div class="form-group">
                    <label>Upload Foto Pendukung</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required style="padding: 15px 20px;">
                </div>
                <button type="submit" name="submit" class="btn-submit">Bagikan Sekarang 🚀</button>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>

<script>
    const modal = document.getElementById("addModal");
    const openBtn = document.getElementById("openModalBtn");
    const closeBtn = document.getElementById("closeModalBtn");

    openBtn.onclick = function() { modal.style.display = "block"; }
    closeBtn.onclick = function() { modal.style.display = "none"; }
    window.onclick = function(event) {
        if (event.target == modal) { modal.style.display = "none"; }
    }

    var typed = new Typed('#teks-animasi', {
        strings: [
            'Simpan momen dan catatan proyekmu di sini...', 
            'Tunjukkan karyamu disini ✨',
            'Satu tempat untuk mengabadikan karyamu!',
            'SEMANGAT! 🌸'
        ],
        typeSpeed: 60,
        backSpeed: 40,
        backDelay: 2500,
        loop: true
    });
</script>

</body>
</html>