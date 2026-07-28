<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'klien'){
    header("Location: ../auth/login.php");
    exit;
}

$id_klien = $_SESSION['id_klien'];

$data = mysqli_query($conn,"

SELECT
event_request.*,
pic.nama_pic

FROM event_request

LEFT JOIN pic
ON event_request.id_pic = pic.id_pic

WHERE event_request.id_klien='$id_klien'

ORDER BY event_request.id_event DESC

");

?>

<!DOCTYPE html>
<html>
<head>

<title>Status Event</title>

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
    box-shadow:0 5px 15px rgba(0,0,0,.05);
}

.table-box{
    background:white;
    margin-top:30px;
    padding:30px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
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

.badge{
    color:white;
    padding:8px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:bold;
}

.pending{
    background:#f59e0b;
}

.disetujui{
    background:#10b981;
}

.ditolak{
    background:#ef4444;
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
        <h1>Status Event Saya</h1>
    </div>

    <div class="table-box">

        <table>

            <tr>

                <th>No</th>
                <th>Nama Event</th>
                <th>Jenis Event</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Peserta</th>
                <th>Budget</th>
                <th>PIC</th>
                <th>Status</th>
                <th>Progress</th>

            </tr>

            <?php

            $no = 1;

            while($d = mysqli_fetch_array($data)){

            ?>

            <tr>

                <td><?= $no++ ?></td>

                <td><?= $d['nama_event'] ?></td>

                <td><?= $d['jenis_event'] ?></td>

                <td><?= $d['kategori_event'] ?></td>

                <td><?= $d['tanggal_event'] ?></td>

                <td><?= $d['lokasi_event'] ?></td>

                <td><?= $d['jumlah_peserta'] ?></td>

                <td><?= $d['budget_event'] ?></td>

                <td>

                    <?php

                    if(!empty($d['nama_pic'])){
                        echo $d['nama_pic'];
                    }else{
                        echo "-";
                    }

                    ?>

                </td>

                <td>

                    <?php

                    if($d['status']=='pending'){

                        echo "<span class='badge pending'>Pending</span>";

                    }
                    elseif($d['status']=='disetujui'){

                        echo "<span class='badge disetujui'>Disetujui</span>";

                    }
                    else{

                        echo "<span class='badge ditolak'>Ditolak</span>";

                    }

                    ?>

                </td>

                <td>

                    <?php

                    if($d['progress_event']=='Persiapan'){

                        echo "<span class='badge persiapan'>Persiapan</span>";

                    }
                    elseif($d['progress_event']=='Pelaksanaan Event'){

                        echo "<span class='badge pelaksanaan'>Pelaksanaan</span>";

                    }
                    elseif($d['progress_event']=='Selesai'){

                        echo "<span class='badge selesai'>Selesai</span>";

                    }
                    else{

                        echo "-";

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