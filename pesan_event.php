<?php

session_start();
include '../config/koneksi.php';

if($_SESSION['role'] != 'klien'){
    header("Location: ../auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Form Permintaan Event</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI';
}

body{
    background:#edf2f7;
}

.sidebar{
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#0f172a,#1e293b);
    position:fixed;
    left:0;
    top:0;
    padding:30px 20px;
}

.logo{
    color:white;
    text-align:center;
    margin-bottom:50px;
}

.logo p{
    color:#94a3b8;
}

.menu a{
    display:block;
    padding:15px;
    margin-bottom:15px;
    text-decoration:none;
    color:#cbd5e1;
    border-radius:12px;
    transition:0.3s;
}

.menu a:hover{
    background:#2563eb;
    color:white;
}

.main{
    margin-left:260px;
    padding:40px;
}

.topbar{
    background:white;
    padding:20px 30px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.form-box{
    background:white;
    margin-top:30px;
    padding:35px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.input-group{
    margin-bottom:20px;
}

.input-group label{
    display:block;
    margin-bottom:8px;
    color:#334155;
    font-weight:600;
}

.input-group input,
.input-group textarea,
.input-group select{
    width:100%;
    padding:15px;
    border:1px solid #cbd5e1;
    border-radius:12px;
    outline:none;
}

textarea{
    resize:none;
    min-height:120px;
}

.file-box{
    border:2px dashed #cbd5e1;
    padding:20px;
    border-radius:15px;
    background:#f8fafc;
}

button{
    padding:15px 25px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:12px;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;
}

button:hover{
    background:#1d4ed8;
}

.info-box{
    background:#eff6ff;
    border-left:5px solid #2563eb;
    padding:15px;
    border-radius:10px;
    margin-bottom:25px;
}

</style>

</head>
<body>

<div class="sidebar">
    <div class="logo">
        <h2>RPM</h2>
        <p>Client Dashboard</p>
    </div>
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="pesan_event.php">Pesan Event</a>
        <a href="status_event.php">Status Event</a>
        <a href="hasil_mom.php">Hasil MoM</a>
        <a href="progress_event.php">Progress Event</a>
        <a href="laporan_event.php">Laporan Event</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="main">

    <div class="topbar">
        <h1>Form Permintaan Event</h1>
    </div>

    <div class="form-box">

        <div class="info-box">
            Silakan isi kebutuhan event sesuai layanan yang tersedia di RPM Management.
        </div>

<form action="proses_pesan_event.php"
method="POST"
enctype="multipart/form-data">

    <div class="input-group">
        <label>Nama Event</label>
        <input type="text"
        name="nama_event"
        required>
    </div>

    <div class="input-group">

        <label>Jenis Event</label>

        <select name="jenis_event" required>

            <option value="">-- Pilih Jenis Event --</option>

            <option value="Brand Activation">
                Brand Activation
            </option>

            <option value="Product Launching">
                Product Launching
            </option>

            <option value="Corporate Event">
                Corporate Event
            </option>

            <option value="Consumer Event">
                Consumer Event
            </option>

            <option value="Sports Event">
                Sports Event
            </option>

            <option value="Festival Event">
                Festival Event
            </option>

        </select>

    </div>

    <div class="input-group">

        <label>Kategori Event</label>

        <select name="kategori_event" required>

            <option value="">-- Pilih Kategori Event --</option>

            <optgroup label="Brand Activation">
                <option value="Sampling Produk">
                    Sampling Produk
                </option>
                <option value="Booth Promosi di Mall">
                    Booth Promosi di Mall
                </option>
                <option value="Games dan Aktivitas Interaktif">
                    Games dan Aktivitas Interaktif
                </option>
                <option value="Test Produk">
                    Test Produk
                </option>
            </optgroup>

            <optgroup label="Product Launching">
                <option value="Launching Mobil">
                    Launching Mobil
                </option>
                <option value="Launching Smartphone">
                    Launching Smartphone
                </option>
                <option value="Launching Produk Makanan">
                    Launching Produk Makanan
                </option>
                <option value="Launching Produk Minuman">
                    Launching Produk Minuman
                </option>
            </optgroup>

            <optgroup label="Corporate Event">
                <option value="Meeting">
                    Meeting
                </option>
                <option value="Seminar">
                    Seminar
                </option>
                <option value="Workshop">
                    Workshop
                </option>
                <option value="Gathering Perusahaan">
                    Gathering Perusahaan
                </option>
                <option value="Annual Meeting">
                    Annual Meeting
                </option>
            </optgroup>

            <optgroup label="Consumer Event">
                <option value="Family Gathering">
                    Family Gathering
                </option>
                <option value="Cooking Class">
                    Cooking Class
                </option>
                <option value="Parenting Class">
                    Parenting Class
                </option>
                <option value="Community Gathering">
                    Community Gathering
                </option>
            </optgroup>

            <optgroup label="Sports Event">
                <option value="Turnamen Futsal">
                    Turnamen Futsal
                </option>
                <option value="Lari Marathon">
                    Lari Marathon
                </option>
                <option value="Fun Run">
                    Fun Run
                </option>
                <option value="Kompetisi E-Sports">
                    Kompetisi E-Sports
                </option>
            </optgroup>

            <optgroup label="Festival Event">
                <option value="Festival Kuliner">
                    Festival Kuliner
                </option>
                <option value="Festival Budaya">
                    Festival Budaya
                </option>
                <option value="Festival UMKM">
                    Festival UMKM
                </option>
                <option value="Festival Musik">
                    Festival Musik
                </option>
            </optgroup>

        </select>

    </div>

    <div class="input-group">
        <label>Tanggal Event</label>
        <input type="date"
        name="tanggal_event"
        required>
    </div>

    <div class="input-group">
        <label>Lokasi Event</label>
        <input type="text"
        name="lokasi_event"
        required>
    </div>

    <div class="input-group">
        <label>Jumlah Peserta</label>
        <input type="number"
        name="jumlah_peserta"
        min="1"
        required>
    </div>

    <div class="input-group">

        <label>Budget Event</label>

        <select name="budget_event" required>

            <option value="">-- Pilih Budget Event --</option>

            <option value="< Rp 10.000.000">
                < Rp 10.000.000
            </option>

            <option value="Rp 10.000.000 - Rp 25.000.000">
                Rp 10.000.000 - Rp 25.000.000
            </option>

            <option value="Rp 25.000.000 - Rp 50.000.000">
                Rp 25.000.000 - Rp 50.000.000
            </option>

            <option value="Rp 50.000.000 - Rp 100.000.000">
                Rp 50.000.000 - Rp 100.000.000
            </option>

            <option value="> Rp 100.000.000">
                > Rp 100.000.000
            </option>

        </select>

    </div>

    <div class="input-group">

        <label>Kebutuhan Event</label>

        <textarea
        name="kebutuhan_event"
        placeholder="Contoh : MC, Talent, Sound System, Booth, Dokumentasi, LED, Dekorasi"
        required></textarea>

    </div>

    <div class="input-group">

        <label>Deskripsi Event</label>

        <textarea
        name="deskripsi"
        placeholder="Jelaskan detail event yang ingin diselenggarakan"
        required></textarea>

    </div>

   <div class="input-group">

    <label>Upload Brief / Proposal Event (PDF)</label>

    <div class="file-box">

        <input
        type="file"
        name="proposal"
        accept=".pdf,application/pdf"
        required>

        <small style="color:#64748b;">
            Format file: PDF | Maksimal ukuran 5 MB
        </small>

    </div>

</div>

    </div>

    <button type="submit">
        KIRIM PERMINTAAN EVENT
    </button>

</form>

    </div>

</div>

</body>
</html>