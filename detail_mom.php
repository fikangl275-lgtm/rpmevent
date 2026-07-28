<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login.php");

    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn,"
SELECT 
mom_event.*,
event_request.nama_event,
klien.nama
FROM mom_event
JOIN event_request 
ON mom_event.id_event = event_request.id_event
JOIN klien
ON event_request.id_klien = klien.id_klien
WHERE id_mom='$id'
");

$d = mysqli_fetch_array($data);

?>

<!DOCTYPE html>
<html>
<head>

<title>Detail Minutes Of Meeting</title>

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
    margin-bottom:30px;
}

.detail-box{
    background:white;
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.item{
    margin-bottom:25px;
}

.item label{
    display:block;
    font-weight:bold;
    margin-bottom:10px;
    color:#334155;
}

.item p{
    background:#f8fafc;
    padding:18px;
    border-radius:14px;
    line-height:1.8;
    color:#334155;
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

        <h1>Detail Minutes Of Meeting</h1>

    </div>

    <div class="detail-box">

        <div class="item">

            <label>Nama Klien</label>

            <p><?= $d['nama'] ?></p>

        </div>

        <div class="item">

            <label>Nama Event</label>

            <p><?= $d['nama_event'] ?></p>

        </div>

        <div class="item">

            <label>Tanggal Meeting</label>

            <p><?= $d['tanggal_meeting'] ?></p>

        </div>

        <div class="item">

            <label>Hasil Meeting</label>

            <p><?= nl2br($d['hasil_meeting']) ?></p>

        </div>

        <a href="data_mom.php" class="btn-back">

            Kembali

        </a>

    </div>

</div>

</body>
</html>