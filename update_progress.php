<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'pic'){
    header("Location: ../auth/login.php");
    exit;
}

$id_event = $_GET['id'];

$data = mysqli_query($conn,"
SELECT *
FROM event_request
WHERE id_event='$id_event'
");

$d = mysqli_fetch_array($data);

if(isset($_POST['update'])){

    $progress_event = mysqli_real_escape_string(
        $conn,
        $_POST['progress_event']
    );

    mysqli_query($conn,"
    UPDATE event_request
    SET progress_event='$progress_event'
    WHERE id_event='$id_event'
    ");

    echo "
    <script>
    alert('Progress event berhasil diperbarui');
    window.location='tugas_event.php';
    </script>
    ";

    exit;
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Update Progress Event</title>

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

.item input,
.item select{
    width:100%;
    padding:15px;
    border:1px solid #cbd5e1;
    border-radius:12px;
    outline:none;
    background:#f8fafc;
}

.btn{
    padding:14px 25px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:12px;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
}

.btn:hover{
    background:#1d4ed8;
}

.btn-back{
    display:inline-block;
    margin-top:20px;
    padding:14px 20px;
    background:#64748b;
    color:white;
    text-decoration:none;
    border-radius:12px;
}

.btn-back:hover{
    background:#475569;
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
        <h1>Update Progress Event</h1>
    </div>

    <div class="form-box">

        <form method="POST">

            <div class="item">
                <label>Nama Event</label>
                <input type="text"
                value="<?= $d['nama_event'] ?>"
                readonly>
            </div>

            <div class="item">
                <label>Jenis Event</label>
                <input type="text"
                value="<?= $d['jenis_event'] ?>"
                readonly>
            </div>

            <div class="item">
                <label>Kategori Event</label>
                <input type="text"
                value="<?= $d['kategori_event'] ?>"
                readonly>
            </div>

            <div class="item">
                <label>Jumlah Peserta</label>
                <input type="text"
                value="<?= $d['jumlah_peserta'] ?>"
                readonly>
            </div>

            <div class="item">
                <label>Budget Event</label>
                <input type="text"
                value="<?= $d['budget_event'] ?>"
                readonly>
            </div>

            <div class="item">

                <label>Progress Event</label>

                <select name="progress_event" required>

                    <option value="">
                        -- Pilih Progress --
                    </option>

                    <option value="Persiapan"
                    <?= ($d['progress_event']=='Persiapan') ? 'selected' : '' ?>>
                        Persiapan
                    </option>

                    <option value="Koordinasi Vendor"
                    <?= ($d['progress_event']=='Koordinasi Vendor') ? 'selected' : '' ?>>
                        Koordinasi Vendor
                    </option>

                    <option value="Pelaksanaan Event"
                    <?= ($d['progress_event']=='Pelaksanaan Event') ? 'selected' : '' ?>>
                        Pelaksanaan Event
                    </option>

                    <option value="Selesai"
                    <?= ($d['progress_event']=='Selesai') ? 'selected' : '' ?>>
                        Selesai
                    </option>

                </select>

            </div>

            <button type="submit"
            name="update"
            class="btn">

                Simpan Progress

            </button>

        </form>

        <a href="tugas_event.php"
        class="btn-back">

            Kembali

        </a>

    </div>

</div>

</body>
</html>