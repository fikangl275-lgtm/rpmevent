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

mom_event.*,
event_request.nama_event,
event_request.tanggal_event

FROM mom_event

JOIN event_request
ON mom_event.id_event = event_request.id_event

WHERE event_request.id_klien='$id_klien'

ORDER BY mom_event.id_mom DESC

");

?>

<!DOCTYPE html>
<html>
<head>

<title>Hasil Minutes Of Meeting</title>

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
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.mom-box{
    background:white;
    padding:30px;
    border-radius:20px;
    margin-bottom:25px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.mom-box h3{
    color:#0f172a;
    margin-bottom:10px;
}

.info{
    color:#64748b;
    margin-bottom:20px;
}

.isi{
    background:#f8fafc;
    padding:20px;
    border-radius:15px;
    line-height:1.8;
    color:#334155;
}

.kosong{
    background:white;
    padding:40px;
    border-radius:20px;
    text-align:center;
    color:#64748b;
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

        <h1>Hasil Minutes Of Meeting</h1>

    </div>

    <?php

    if(mysqli_num_rows($data) > 0){

        while($d = mysqli_fetch_array($data)){

    ?>

        <div class="mom-box">

            <h3>
                <?= $d['nama_event'] ?>
            </h3>

<div class="info">

    📅 Tanggal Meeting :
    <?= date('d-m-Y', strtotime($d['tanggal_meeting'])) ?>

    <br>

    🎉 Tanggal Event :
    <?= date('d-m-Y', strtotime($d['tanggal_event'])) ?>

</div>

            <div class="isi">

                <?= nl2br($d['hasil_meeting']) ?>

            </div>

        </div>

    <?php

        }

    }else{

    ?>

        <div class="kosong">

            Belum ada data Minutes Of Meeting.

        </div>

    <?php } ?>

</div>

</body>
</html>