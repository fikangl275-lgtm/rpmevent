<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login.php");

    exit;
}

$id = $_GET['id'];

# =========================
# DATA EVENT
# =========================

$event = mysqli_query($conn,"
SELECT 
event_request.*,
klien.nama
FROM event_request
JOIN klien
ON event_request.id_klien = klien.id_klien
WHERE id_event='$id'
");

$e = mysqli_fetch_array($event);

# =========================
# DATA PIC
# =========================

$pic = mysqli_query($conn,"
SELECT * FROM pic
ORDER BY nama_pic ASC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Assign PIC Event</title>

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

.content-box{
    background:white;
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    max-width:800px;
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
    padding:16px;
    border-radius:12px;
    color:#334155;
}

select{
    width:100%;
    padding:15px;
    border:1px solid #cbd5e1;
    border-radius:14px;
    outline:none;
    font-size:15px;
}

select:focus{
    border-color:#2563eb;
}

.btn-submit{
    width:100%;
    margin-top:20px;
    padding:16px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:14px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn-submit:hover{
    background:#1d4ed8;
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

        <h1>Assign PIC Event</h1>

    </div>

    <div class="content-box">

        <div class="item">

            <label>Nama Klien</label>

            <p><?= $e['nama'] ?></p>

        </div>

        <div class="item">

            <label>Nama Event</label>

            <p><?= $e['nama_event'] ?></p>

        </div>

        <div class="item">

            <label>Jenis Event</label>

            <p><?= $e['jenis_event'] ?></p>

        </div>

        <div class="item">

            <label>Tanggal Event</label>

            <p><?= $e['tanggal_event'] ?></p>

        </div>

        <form action="proses_assign_pic.php" method="POST">

            <input 
            type="hidden" 
            name="id_event"
            value="<?= $e['id_event'] ?>">

            <div class="item">

                <label>Pilih PIC Event</label>

                <select name="id_pic">

                    <option value="">
                        -- Pilih PIC --
                    </option>

                    <?php while($p = mysqli_fetch_array($pic)){ ?>

                    <option value="<?= $p['id_pic'] ?>">

                        <?= $p['nama_pic'] ?>

                    </option>

                    <?php } ?>

                </select>

            </div>

            <button type="submit" class="btn-submit">

                ASSIGN PIC EVENT

            </button>

        </form>

    </div>

</div>

</body>
</html>