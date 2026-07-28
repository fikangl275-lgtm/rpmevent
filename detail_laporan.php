<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login.php");

    exit;
}

$id = $_GET['id'];

# =====================================
# DETAIL LAPORAN
# =====================================

$data = mysqli_query($conn,"
SELECT

laporan_event.*,
event_request.nama_event,
event_request.jenis_event,
event_request.tanggal_event,
klien.nama

FROM laporan_event

JOIN event_request
ON laporan_event.id_event = event_request.id_event

JOIN klien
ON event_request.id_klien = klien.id_klien

WHERE id_laporan='$id'
");

$d = mysqli_fetch_array($data);

?>

<!DOCTYPE html>
<html>
<head>

<title>Detail Laporan Event</title>

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
    overflow:auto;
}

.logo{
    text-align:center;
    color:white;
    margin-bottom:50px;
}

.logo h2{
    font-size:28px;
}

.logo p{
    color:#94a3b8;
}

.menu a{
    display:block;
    padding:15px;
    margin-bottom:15px;
    border-radius:12px;
    text-decoration:none;
    color:#cbd5e1;
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
    padding:25px 30px;
    border-radius:20px;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.topbar h1{
    color:#0f172a;
}

.content-box{
    background:white;
    padding:35px;
    border-radius:24px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.item{
    margin-bottom:25px;
}

.item label{
    display:block;
    font-weight:bold;
    margin-bottom:10px;
    color:#0f172a;
}

.item p{
    background:#f8fafc;
    padding:18px;
    border-radius:14px;
    color:#334155;
    line-height:1.8;
}

.drive-link{
    display:inline-block;
    margin-top:10px;
    padding:14px 20px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:12px;
    transition:0.3s;
}

.drive-link:hover{
    background:#1d4ed8;
}

.btn-back{
    display:inline-block;
    margin-top:20px;
    padding:14px 20px;
    background:#0f172a;
    color:white;
    text-decoration:none;
    border-radius:12px;
    transition:0.3s;
}

.btn-back:hover{
    background:#1e293b;
}

</style>

</head>
<body>

<div class="sidebar">
    <div class="logo">
        <h2>RPM</h2>
        <p>Admin Dashboard</p>
    </div>
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="data_pic.php">Data PIC</a>
        <a href="approval_event.php">Approval Event</a>
        <a href="rekap_event.php">Rekap Event</a>
        <a href="progress_event.php">Progress Event</a>
        <a href="data_mom.php">Minutes Of Meeting</a>
        <a href="data_laporan.php">Laporan Event</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="main">

    <div class="topbar">

        <h1>Detail Laporan Event</h1>

    </div>

    <div class="content-box">

        <div class="item">

            <label>Nama Klien</label>

            <p>

                <?= $d['nama'] ?>

            </p>

        </div>

        <div class="item">

            <label>Nama Event</label>

            <p>

                <?= $d['nama_event'] ?>

            </p>

        </div>

        <div class="item">

            <label>Jenis Event</label>

            <p>

                <?= $d['jenis_event'] ?>

            </p>

        </div>

        <div class="item">

            <label>Tanggal Event</label>

            <p>

                <?= $d['tanggal_event'] ?>

            </p>

        </div>

        <div class="item">

            <label>Judul Laporan</label>

            <p>

                <?= $d['judul_laporan'] ?>

            </p>

        </div>

        <div class="item">

            <label>Isi Laporan</label>

            <p>

                <?= nl2br($d['isi_laporan']) ?>

            </p>

        </div>

        <div class="item">

            <label>Tanggal Laporan</label>

            <p>

                <?= $d['tanggal_laporan'] ?>

            </p>

        </div>

        <div class="item">

            <label>Dokumentasi Event</label>

            <a 
            href="<?= $d['link_drive'] ?>"
            target="_blank"
            class="drive-link">

                Buka Google Drive

            </a>

        </div>

        <a 
        href="data_laporan.php"
        class="btn-back">

            Kembali

        </a>

    </div>

</div>

</body>
</html>