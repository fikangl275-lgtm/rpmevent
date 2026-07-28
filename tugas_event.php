<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'pic'){
    header("Location: ../auth/login.php");
    exit;
}

$id_pic = $_SESSION['id_pic'];

$data = mysqli_query($conn,"

SELECT
event_request.*,
klien.nama
FROM event_request
JOIN klien
ON event_request.id_klien = klien.id_klien
WHERE event_request.id_pic='$id_pic'
ORDER BY event_request.id_event DESC

");

?>

<!DOCTYPE html>
<html>
<head>

<title>Tugas Event PIC</title>

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

.table-box{
    background:white;
    margin-top:30px;
    padding:30px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table th{
    background:#f8fafc;
    padding:15px;
    text-align:left;
    white-space:nowrap;
}

table td{
    padding:15px;
    border-bottom:1px solid #e2e8f0;
    white-space:nowrap;
}

.progress{
    padding:8px 15px;
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

.btn-update{
    background:#2563eb;
    color:white;
    padding:10px 15px;
    border-radius:10px;
    text-decoration:none;
    font-size:14px;
}

.btn-update:hover{
    background:#1d4ed8;
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
        <h1>Tugas Event PIC</h1>
    </div>

    <div class="table-box">

        <table>

            <tr>

                <th>No</th>

                <th>Klien</th>

                <th>Nama Event</th>

                <th>Jenis Event</th>

                <th>Kategori</th>

                <th>Tanggal</th>

                <th>Lokasi</th>

                <th>Peserta</th>

                <th>Budget</th>

                <th>Progress</th>

                <th>Aksi</th>

            </tr>

            <?php

            $no = 1;

            while($d = mysqli_fetch_array($data)){

            ?>

            <tr>

                <td><?= $no++ ?></td>

                <td><?= $d['nama'] ?></td>

                <td><?= $d['nama_event'] ?></td>

                <td><?= $d['jenis_event'] ?></td>

                <td><?= $d['kategori_event'] ?></td>

                <td><?= $d['tanggal_event'] ?></td>

                <td><?= $d['lokasi_event'] ?></td>

                <td><?= $d['jumlah_peserta'] ?></td>

                <td><?= $d['budget_event'] ?></td>

                <td>

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

                        echo "<span class='progress persiapan'>Belum Dimulai</span>";

                    }

                    ?>

                </td>

                <td>

                    <a href="update_progress.php?id=<?= $d['id_event'] ?>"
                    class="btn-update">

                        Update

                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>