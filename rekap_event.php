<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login.php");
    exit;
}

# =====================================
# FILTER
# =====================================

$where = "";

if(isset($_GET['filter'])){

    $filter = $_GET['filter'];

    if($filter == "berjalan"){

        $where = "
        WHERE progress_event='Persiapan'
        OR progress_event='Pelaksanaan Event'
        ";

    }

    elseif($filter == "selesai"){

        $where = "
        WHERE progress_event='Selesai'
        ";

    }

    elseif($filter == "ditolak"){

        $where = "
        WHERE status='ditolak'
        ";

    }

}

# =====================================
# STATISTIK
# =====================================

$total_event = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM event_request
")
);

$total_berjalan = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM event_request
WHERE progress_event='Persiapan'
OR progress_event='Pelaksanaan Event'
")
);

$total_selesai = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM event_request
WHERE progress_event='Selesai'
")
);

$total_ditolak = mysqli_num_rows(
mysqli_query($conn,"
SELECT * FROM event_request
WHERE status='ditolak'
")
);

# =====================================
# DATA EVENT
# =====================================

$data = mysqli_query($conn,"

SELECT

event_request.*,
klien.nama,
pic.nama_pic

FROM event_request

LEFT JOIN klien
ON event_request.id_klien = klien.id_klien

LEFT JOIN pic
ON event_request.id_pic = pic.id_pic

$where

ORDER BY event_request.id_event DESC

");

?>

<!DOCTYPE html>
<html>
<head>

<title>Rekap Event</title>

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

.card-area{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:30px;
}

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.card h3{
    color:#64748b;
    margin-bottom:10px;
}

.card h2{
    color:#0f172a;
}

.table-box{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.filter{
    margin-bottom:20px;
}

.filter select{
    padding:12px;
    border:1px solid #cbd5e1;
    border-radius:10px;
}

.filter button{
    padding:12px 20px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:10px;
    cursor:pointer;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f8fafc;
    padding:15px;
    text-align:left;
}

table td{
    padding:15px;
    border-bottom:1px solid #e2e8f0;
}

.badge{
    padding:8px 14px;
    border-radius:30px;
    color:white;
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

.progress{
    background:#2563eb;
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

        <h1>Rekap Event</h1>

    </div>

    <div class="card-area">

        <div class="card">
            <h3>Total Event</h3>
            <h2><?= $total_event ?></h2>
        </div>

        <div class="card">
            <h3>Event Berjalan</h3>
            <h2><?= $total_berjalan ?></h2>
        </div>

        <div class="card">
            <h3>Event Selesai</h3>
            <h2><?= $total_selesai ?></h2>
        </div>

        <div class="card">
            <h3>Event Ditolak</h3>
            <h2><?= $total_ditolak ?></h2>
        </div>

    </div>

    <div class="table-box">

        <form method="GET" class="filter">

            <select name="filter">

                <option value="">
                    Semua Event
                </option>

                <option value="berjalan">
                    Event Berjalan
                </option>

                <option value="selesai">
                    Event Selesai
                </option>

                <option value="ditolak">
                    Event Ditolak
                </option>

            </select>

            <button type="submit">

                Filter

            </button>

        </form>

        <table>

            <tr>

                <th>No</th>
                <th>Nama Event</th>
                <th>Klien</th>
                <th>PIC</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Budget</th>
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

                <td><?= $d['nama'] ?></td>

                <td>

                    <?= !empty($d['nama_pic'])
                    ? $d['nama_pic']
                    : '-' ?>

                </td>

                <td><?= $d['kategori_event'] ?></td>

                <td><?= $d['tanggal_event'] ?></td>

                <td><?= $d['budget_event'] ?></td>

                <td>

                    <?php

                    if($d['status']=="pending"){

                        echo "<span class='badge pending'>Pending</span>";

                    }

                    elseif($d['status']=="disetujui"){

                        echo "<span class='badge disetujui'>Disetujui</span>";

                    }

                    else{

                        echo "<span class='badge ditolak'>Ditolak</span>";

                    }

                    ?>

                </td>

                <td>

                    <span class="badge progress">

                        <?= $d['progress_event'] ?>

                    </span>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>