<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login.php");

    exit;
}

# =====================================
# TAMBAH LAPORAN
# =====================================

if(isset($_POST['tambah_laporan'])){

    $id_event = $_POST['id_event'];

    $judul = mysqli_real_escape_string(
    $conn,
    $_POST['judul_laporan']
    );

    $isi = mysqli_real_escape_string(
    $conn,
    $_POST['isi_laporan']
    );

    $link = mysqli_real_escape_string(
    $conn,
    $_POST['link_drive']
    );

    $tanggal = $_POST['tanggal_laporan'];

    mysqli_query($conn,"
    INSERT INTO laporan_event(

    id_event,
    judul_laporan,
    isi_laporan,
    link_drive,
    tanggal_laporan

    )

    VALUES(

    '$id_event',

    '$judul',

    '$isi',

    '$link',

    '$tanggal'

    )
    ");

    echo "

    <script>

    alert('Laporan event berhasil ditambahkan');

    window.location='data_laporan.php';

    </script>

    ";

}

# =====================================
# UPDATE LAPORAN
# =====================================

if(isset($_POST['update_laporan'])){

    $id_laporan = $_POST['id_laporan'];

    $id_event = $_POST['id_event'];

    $judul = mysqli_real_escape_string(
    $conn,
    $_POST['judul_laporan']
    );

    $isi = mysqli_real_escape_string(
    $conn,
    $_POST['isi_laporan']
    );

    $link = mysqli_real_escape_string(
    $conn,
    $_POST['link_drive']
    );

    $tanggal = $_POST['tanggal_laporan'];

    mysqli_query($conn,"
    UPDATE laporan_event SET

    id_event='$id_event',
    judul_laporan='$judul',
    isi_laporan='$isi',
    link_drive='$link',
    tanggal_laporan='$tanggal'

    WHERE id_laporan='$id_laporan'
    ");

    echo "

    <script>

    alert('Laporan event berhasil diupdate');

    window.location='data_laporan.php';

    </script>

    ";

}

# =====================================
# MODE EDIT
# =====================================

$edit_mode = false;

$edit_data = null;

if(isset($_GET['edit'])){

    $edit_mode = true;

    $id_edit = $_GET['edit'];

    $ambil = mysqli_query($conn,"
    SELECT * FROM laporan_event
    WHERE id_laporan='$id_edit'
    ");

    $edit_data = mysqli_fetch_array($ambil);

}

# =====================================
# DATA EVENT
# =====================================

$event = mysqli_query($conn,"
SELECT * FROM event_request
WHERE status='disetujui'
");

# =====================================
# DATA LAPORAN
# =====================================

$data = mysqli_query($conn,"
SELECT

laporan_event.*,
event_request.nama_event,
klien.nama

FROM laporan_event

JOIN event_request
ON laporan_event.id_event = event_request.id_event

JOIN klien
ON event_request.id_klien = klien.id_klien

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

.container{
    display:grid;
    grid-template-columns:1fr 1.5fr;
    gap:30px;
}

.form-box,
.table-box{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.form-box h2,
.table-box h2{
    margin-bottom:25px;
}

.input-group{
    margin-bottom:20px;
}

.input-group label{
    display:block;
    margin-bottom:10px;
    font-weight:600;
}

.input-group input,
.input-group select,
.input-group textarea{
    width:100%;
    padding:14px;
    border:1px solid #cbd5e1;
    border-radius:12px;
    outline:none;
}

textarea{
    resize:none;
    height:140px;
}

.btn-submit{
    width:100%;
    padding:15px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:12px;
    font-weight:bold;
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

.btn-detail{
    background:#10b981;
    color:white;
    padding:8px 14px;
    border-radius:10px;
    text-decoration:none;
    margin-right:6px;
}

.btn-edit{
    background:#f59e0b;
    color:white;
    padding:8px 14px;
    border-radius:10px;
    text-decoration:none;
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

        <h1>Laporan Event</h1>

    </div>

    <div class="container">

        <div class="form-box">

            <?php if($edit_mode){ ?>

            <h2>Edit Laporan</h2>

            <?php } else { ?>

            <h2>Tambah Laporan</h2>

            <?php } ?>

            <form method="POST">

                <?php if($edit_mode){ ?>

                <input 
                type="hidden"
                name="id_laporan"
                value="<?= $edit_data['id_laporan'] ?>">

                <?php } ?>

                <div class="input-group">

                    <label>Pilih Event</label>

                    <select name="id_event">

                        <?php

                        $event2 = mysqli_query($conn,"
                        SELECT * FROM event_request
                        WHERE status='disetujui'
                        ");

                        while($e = mysqli_fetch_array($event2)){

                        ?>

                        <option 
                        value="<?= $e['id_event'] ?>"

                        <?php

                        if($edit_mode){

                            if($edit_data['id_event'] == $e['id_event']){

                                echo "selected";

                            }

                        }

                        ?>

                        >

                        <?= $e['nama_event'] ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="input-group">

                    <label>Judul Laporan</label>

                    <input 
                    type="text"
                    name="judul_laporan"

                    value="<?php

                    if($edit_mode){

                        echo $edit_data['judul_laporan'];

                    }

                    ?>">

                </div>

                <div class="input-group">

                    <label>Isi Laporan</label>

                    <textarea 
                    name="isi_laporan"><?php

                    if($edit_mode){

                        echo $edit_data['isi_laporan'];

                    }

                    ?></textarea>

                </div>

                <div class="input-group">

                    <label>Link Google Drive</label>

                    <input 
                    type="text"
                    name="link_drive"

                    value="<?php

                    if($edit_mode){

                        echo $edit_data['link_drive'];

                    }

                    ?>">

                </div>

                <div class="input-group">

                    <label>Tanggal Laporan</label>

                    <input 
                    type="date"
                    name="tanggal_laporan"

                    value="<?php

                    if($edit_mode){

                        echo $edit_data['tanggal_laporan'];

                    }

                    ?>">

                </div>

                <?php if($edit_mode){ ?>

                <button 
                type="submit"
                name="update_laporan"
                class="btn-submit">

                    UPDATE LAPORAN

                </button>

                <?php } else { ?>

                <button 
                type="submit"
                name="tambah_laporan"
                class="btn-submit">

                    SIMPAN LAPORAN

                </button>

                <?php } ?>

            </form>

        </div>

        <div class="table-box">

            <h2>Data Laporan Event</h2>

            <table>

                <tr>

                    <th>No</th>

                    <th>Klien</th>

                    <th>Event</th>

                    <th>Tanggal</th>

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

                    <td><?= $d['tanggal_laporan'] ?></td>

                    <td>

                        <a 
                        href="detail_laporan.php?id=<?= $d['id_laporan'] ?>"
                        class="btn-detail">

                            Detail

                        </a>

                        <a 
                        href="data_laporan.php?edit=<?= $d['id_laporan'] ?>"
                        class="btn-edit">

                            Edit

                        </a>

                    </td>

                </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</div>

</body>
</html>