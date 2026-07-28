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
event_request.*,
klien.nama
FROM event_request
JOIN klien
ON event_request.id_klien = klien.id_klien
WHERE event_request.id_event='$id'

");

$d = mysqli_fetch_array($data);

?>

<!DOCTYPE html>
<html>
<head>

<title>Detail Event</title>

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

.status{
    display:inline-block;
    padding:10px 18px;
    border-radius:30px;
    color:white;
    font-size:14px;
    font-weight:bold;
}

.pending{
    background:#f59e0b;
}

.success{
    background:#10b981;
}

.danger{
    background:#ef4444;
}

.progress{
    display:inline-block;
    padding:10px 18px;
    border-radius:30px;
    color:white;
    font-size:14px;
    font-weight:bold;
}

.persiapan{
    background:#f59e0b;
}

.proses{
    background:#2563eb;
}

.selesai{
    background:#10b981;
}

.btn-download{
    display:inline-block;
    margin-top:10px;
    padding:14px 20px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:12px;
}

.btn-download:hover{
    background:#1d4ed8;
}

.btn-back{
    display:inline-block;
    margin-top:30px;
    padding:14px 20px;
    background:#0f172a;
    color:white;
    text-decoration:none;
    border-radius:12px;
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

        <h1>Detail Event</h1>

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

            <label>Jenis Event</label>

            <p><?= $d['jenis_event'] ?></p>

        </div>

        <div class="item">

            <label>Kategori Event</label>

            <p><?= $d['kategori_event'] ?></p>

        </div>

        <div class="item">

            <label>Tanggal Event</label>

            <p><?= $d['tanggal_event'] ?></p>

        </div>

        <div class="item">

            <label>Lokasi Event</label>

            <p><?= $d['lokasi_event'] ?></p>

        </div>

        <div class="item">

            <label>Jumlah Peserta</label>

            <p><?= $d['jumlah_peserta'] ?> Orang</p>

        </div>

        <div class="item">

            <label>Budget Event</label>

            <p><?= $d['budget_event'] ?></p>

        </div>

        <div class="item">

            <label>Kebutuhan Event</label>

            <p><?= nl2br($d['kebutuhan_event']) ?></p>

        </div>

        <div class="item">

            <label>Status Event</label>

            <p>

            <?php

            if($d['status'] == 'pending'){

                echo "<span class='status pending'>Pending</span>";

            }

            elseif($d['status'] == 'disetujui'){

                echo "<span class='status success'>Disetujui</span>";

            }

            else{

                echo "<span class='status danger'>Ditolak</span>";

            }

            ?>

            </p>

        </div>

        <div class="item">

            <label>Progress Event</label>

            <p>

            <?php

            if($d['progress_event'] == 'Persiapan'){

                echo "<span class='progress persiapan'>Persiapan</span>";

            }

            elseif($d['progress_event'] == 'Proses'){

                echo "<span class='progress proses'>Proses</span>";

            }

            elseif($d['progress_event'] == 'Selesai'){

                echo "<span class='progress selesai'>Selesai</span>";

            }

            else{

                echo "-";

            }

            ?>

            </p>

        </div>

        <div class="item">

            <label>Deskripsi Event</label>

            <p><?= nl2br($d['deskripsi']) ?></p>

        </div>

        <div class="item">

            <label>Proposal Event</label>

            <br>

            <?php if(!empty($d['file_proposal'])){ ?>

                <a href="../uploads/<?= $d['file_proposal'] ?>"
                class="btn-download"
                target="_blank">

                    Download Proposal

                </a>

            <?php }else{ ?>

                <p>Tidak ada proposal yang diupload</p>

            <?php } ?>

        </div>

        <a href="approval_event.php" class="btn-back">

            Kembali

        </a>

    </div>

</div>

</body>
</html>