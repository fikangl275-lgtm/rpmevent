<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login.php");

    exit;
}

$id_event = $_GET['id'];

$cek = mysqli_query($conn,"
SELECT *
FROM event_request
WHERE id_event='$id_event'
");

if(mysqli_num_rows($cek) == 0){

    echo "

    <script>

    alert('Data event tidak ditemukan');

    window.location='approval_event.php';

    </script>

    ";

    exit;
}

$d = mysqli_fetch_array($cek);

if($d['status'] != 'pending'){

    echo "

    <script>

    alert('Event sudah diproses sebelumnya');

    window.location='approval_event.php';

    </script>

    ";

    exit;
}

if(isset($_POST['simpan'])){

    $id_pic = $_POST['id_pic'];

    if(empty($id_pic)){

        echo "

        <script>

        alert('Silakan pilih PIC terlebih dahulu');

        </script>

        ";

    }else{

        mysqli_query($conn,"

        UPDATE event_request

        SET

        status='disetujui',
        progress_event='Persiapan',
        id_pic='$id_pic'

        WHERE id_event='$id_event'

        ");

        echo "

        <script>

        alert('Event berhasil disetujui dan PIC telah ditugaskan');

        window.location='approval_event.php';

        </script>

        ";

        exit;
    }
}

$pic = mysqli_query($conn,"
SELECT *
FROM pic
ORDER BY nama_pic ASC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Setujui Event</title>

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

.form-box{
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.item{
    margin-bottom:20px;
}

.item label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
    color:#334155;
}

.item p{
    background:#f8fafc;
    padding:15px;
    border-radius:12px;
}

select{
    width:100%;
    padding:15px;
    border:1px solid #cbd5e1;
    border-radius:12px;
}

.btn{
    background:#10b981;
    color:white;
    border:none;
    padding:15px 25px;
    border-radius:12px;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
}

.btn:hover{
    background:#059669;
}

.btn-back{
    display:inline-block;
    margin-left:10px;
    background:#334155;
    color:white;
    text-decoration:none;
    padding:15px 25px;
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

        <h1>Setujui Event</h1>

    </div>

    <div class="form-box">

        <div class="item">
            <label>Nama Event</label>
            <p><?= $d['nama_event']; ?></p>
        </div>

        <div class="item">
            <label>Jenis Event</label>
            <p><?= $d['jenis_event']; ?></p>
        </div>

        <div class="item">
            <label>Kategori Event</label>
            <p><?= $d['kategori_event']; ?></p>
        </div>

        <div class="item">
            <label>Tanggal Event</label>
            <p><?= $d['tanggal_event']; ?></p>
        </div>

        <div class="item">
            <label>Jumlah Peserta</label>
            <p><?= $d['jumlah_peserta']; ?> Orang</p>
        </div>

        <div class="item">
            <label>Budget Event</label>
            <p><?= $d['budget_event']; ?></p>
        </div>

        <div class="item">
            <label>Lokasi Event</label>
            <p><?= $d['lokasi_event']; ?></p>
        </div>

        <form method="POST">

            <div class="item">

                <label>Pilih PIC</label>

                <select name="id_pic" required>

                    <option value="">
                        -- Pilih PIC --
                    </option>

                    <?php while($p = mysqli_fetch_array($pic)){ ?>

                    <option value="<?= $p['id_pic']; ?>">

                        <?= $p['nama_pic']; ?>

                    </option>

                    <?php } ?>

                </select>

            </div>

            <button
            type="submit"
            name="simpan"
            class="btn">

                Setujui Event

            </button>

            <a
            href="approval_event.php"
            class="btn-back">

                Kembali

            </a>

        </form>

    </div>

</div>

</body>
</html>