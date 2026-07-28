<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'klien'){

    header("Location: ../auth/login.php");

    exit;
}

$id_klien = $_SESSION['id_klien'];

# =====================================
# DATA LAPORAN EVENT
# =====================================

$data = mysqli_query($conn,"
SELECT

laporan_event.*,
event_request.nama_event,
event_request.jenis_event

FROM laporan_event

JOIN event_request
ON laporan_event.id_event = event_request.id_event

WHERE event_request.id_klien='$id_klien'

ORDER BY id_laporan DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Laporan Event</title>

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

.card{
    background:white;
    padding:30px;
    border-radius:22px;
    margin-bottom:25px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-4px);
}

.card h2{
    color:#0f172a;
    margin-bottom:15px;
}

.info{
    margin-bottom:12px;
    color:#475569;
    line-height:1.7;
}

.label{
    font-weight:bold;
    color:#0f172a;
}

.deskripsi{
    margin-top:20px;
    background:#f8fafc;
    padding:18px;
    border-radius:14px;
    line-height:1.8;
    color:#334155;
}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:13px 20px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:12px;
    transition:0.3s;
}

.btn:hover{
    background:#1d4ed8;
}

.empty{
    background:white;
    padding:40px;
    border-radius:20px;
    text-align:center;
    color:#64748b;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
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

        <h1>Laporan Event Saya</h1>

    </div>

    <?php

    if(mysqli_num_rows($data) > 0){

        while($d = mysqli_fetch_array($data)){

    ?>

    <div class="card">

        <h2>

            <?= $d['judul_laporan'] ?>

        </h2>

        <div class="info">

            <span class="label">

                Nama Event :

            </span>

            <?= $d['nama_event'] ?>

        </div>

        <div class="info">

            <span class="label">

                Jenis Event :

            </span>

            <?= $d['jenis_event'] ?>

        </div>

        <div class="info">

            <span class="label">

                Tanggal Laporan :

            </span>

            <?= $d['tanggal_laporan'] ?>

        </div>

        <div class="deskripsi">

            <?= nl2br($d['isi_laporan']) ?>

        </div>

        <a 
        href="<?= $d['link_drive'] ?>"
        target="_blank"
        class="btn">

            Buka Dokumentasi Event

        </a>

    </div>

    <?php

        }

    } else {

    ?>

    <div class="empty">

        <h2>Belum Ada Laporan Event</h2>

        <br>

        <p>

            Laporan event dari admin akan tampil di halaman ini.

        </p>

    </div>

    <?php } ?>

</div>

</body>
</html>