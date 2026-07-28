<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'pic'){
    header("Location: ../auth/login.php");
    exit;
}

$id_pic = $_SESSION['id_pic'];

$total_tugas = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM event_request
WHERE id_pic='$id_pic'
"));

$persiapan = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM event_request
WHERE id_pic='$id_pic'
AND progress_event='Persiapan'
"));

$pelaksanaan = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM event_request
WHERE id_pic='$id_pic'
AND progress_event='Pelaksanaan Event'
"));

$selesai = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM event_request
WHERE id_pic='$id_pic'
AND progress_event='Selesai'
"));

$tugas = mysqli_query($conn,"
SELECT
event_request.*,
klien.nama
FROM event_request
JOIN klien
ON event_request.id_klien = klien.id_klien
WHERE event_request.id_pic='$id_pic'
ORDER BY event_request.id_event DESC
LIMIT 5
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard PIC</title>

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
    transition:.3s;
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
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 5px 15px rgba(0,0,0,.05);
}

.profile{
    background:#2563eb;
    color:white;
    padding:10px 20px;
    border-radius:12px;
}

.card-area{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.card h3{
    color:#64748b;
    margin-bottom:10px;
}

.card h2{
    color:#0f172a;
    font-size:35px;
}

.table-box{
    margin-top:35px;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th{
    background:#f8fafc;
    padding:14px;
    text-align:left;
    white-space:nowrap;
}

table td{
    padding:14px;
    border-bottom:1px solid #e2e8f0;
    white-space:nowrap;
}

.badge{
    padding:8px 15px;
    border-radius:20px;
    color:white;
    font-size:13px;
    font-weight:bold;
}

.persiapan{
    background:#f59e0b;
}

.pelaksanaan{
    background:#2563eb;
}

.selesai{
    background:#10b981;
}

</style>

</head>
<body>

<div class="sidebar">
    <div class="logo">
        <h2>RPM</h2>
        <p>PIC Dashboard</p>
    </div>
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="tugas_event.php">Tugas Event</a>
        <a href="progress_event.php">Kelola Progress</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="main">

    <div class="topbar">

        <h1>
            Selamat Datang,
            <?= $_SESSION['nama']; ?>
        </h1>

        <div class="profile">
            PIC
        </div>

    </div>

    <div class="card-area">

        <div class="card">
            <h3>Total Tugas</h3>
            <h2><?= $total_tugas ?></h2>
        </div>

        <div class="card">
            <h3>Persiapan</h3>
            <h2><?= $persiapan ?></h2>
        </div>

        <div class="card">
            <h3>Pelaksanaan Event</h3>
            <h2><?= $pelaksanaan ?></h2>
        </div>

        <div class="card">
            <h3>Selesai</h3>
            <h2><?= $selesai ?></h2>
        </div>

    </div>

    <div class="table-box">

        <h2>Tugas Event Terbaru</h2>

        <table>

            <tr>
                <th>Klien</th>
                <th>Nama Event</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Budget</th>
                <th>Progress</th>
            </tr>

            <?php while($d = mysqli_fetch_array($tugas)){ ?>

            <tr>

                <td><?= $d['nama']; ?></td>

                <td><?= $d['nama_event']; ?></td>

                <td><?= $d['kategori_event']; ?></td>

                <td><?= $d['tanggal_event']; ?></td>

                <td><?= $d['lokasi_event']; ?></td>

                <td><?= $d['budget_event']; ?></td>

                <td>

                    <?php

                    if($d['progress_event']=="Persiapan"){

                        echo "<span class='badge persiapan'>Persiapan</span>";

                    }
                    elseif($d['progress_event']=="Pelaksanaan Event"){

                        echo "<span class='badge pelaksanaan'>Pelaksanaan</span>";

                    }
                    elseif($d['progress_event']=="Selesai"){

                        echo "<span class='badge selesai'>Selesai</span>";

                    }
                    else{

                        echo "<span class='badge persiapan'>Belum Diproses</span>";

                    }

                    ?>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>